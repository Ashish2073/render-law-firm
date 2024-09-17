<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Google_Client;
use GuzzleHttp\Client;
use App\Models\JobStatus;
use Exception;


class SendPushNotificationToCustomer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $fcmTokensWithCustomerIds;
    protected $title;
    protected $body;

    protected $notificationId;

    protected $customerId;

    protected $jobId;

    protected $imageUrl;



    public function __construct($fcmTokensWithCustomerIds, $title, $body, $pushNotificationId, $jobId, $notification_image)
    {


        $this->fcmTokensWithCustomerIds = $fcmTokensWithCustomerIds;
        $this->title = $title;
        $this->body = $body;
        $this->notificationId = $pushNotificationId;
        $this->jobId = $jobId;
        $this->imageUrl = asset('notification_image/' . $notification_image);




    }

    public function handle(): void
    {
        $serviceAccountKeyFilePath = public_path('render-law-firm-b1141-firebase-adminsdk-c6hk8-57d9ee4c14.json');

        $client = new Google_Client();
        $client->setAuthConfig($serviceAccountKeyFilePath);
        $client->setScopes([env('GOOGLE_NOTIFICATION_AUTH_API_URL')]);
        $client->fetchAccessTokenWithAssertion();
        $accessToken = $client->getAccessToken()['access_token'];





        $url = 'https://fcm.googleapis.com/v1/projects/render-law-firm-b1141/messages:send';
        $client = new Client();



        ///1-pending,2-completed,3-Not Send To All Users,4-failed
        if (!isset($this->jobId)) {
            $jobStatus = JobStatus::create([
                'job_id' => $this->job->getJobId(),
                'job_name' => SendPushNotificationToCustomer::class,
                'status' => '1',
                'push_notification_id' => $this->notificationId
            ]);
        } else {
            $jobStatus = JobStatus::find($this->jobId);
        }

        $allNotificationsSent = true;

        $n = 0;

        foreach ($this->fcmTokensWithCustomerIds as $data) {
            // $payload = [
            //     'message' => [
            //         'token' => $data['fcm_token'],
            //         'notification' => [
            //             'body' => $this->body,
            //             'title' => $this->title,
            //         ],
            //     ],
            // ];

            $payload = [
                'message' => [
                    'token' => $data['fcm_token'],
                    'notification' => [
                        'body' => $this->body,
                        'title' => $this->title,
                    ],
                    'android' => [
                        'notification' => [
                            'image' => $this->imageUrl,
                        ],
                    ],
                    'apns' => [
                        'payload' => [
                            'aps' => [
                                'mutable-content' => 1,
                            ],
                        ],
                        'fcm_options' => [
                            'image' => $this->imageUrl,
                        ],
                    ],
                    'webpush' => [
                        'notification' => [
                            'image' => $this->imageUrl,
                        ],
                    ],
                ],
            ];
            try {
                $response = $client->post($url, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken,
                        'Content-Type' => 'application/json',
                    ],
                    'json' => $payload,
                ]);

                ++$n;

            } catch (Exception $e) {


                Log::info('Failed to send notification', [
                    'customer_id' => $data['customer_id'],
                    'token' => $data['fcm_token'],
                    'error' => $e->getMessage(),

                ]);


                $allNotificationsSent = false;
            }
        }


        if ($allNotificationsSent) {
            $jobStatus->update(['status' => '2']);
        } elseif ($n > 0) {
            $jobStatus->update(['status' => '3']);
        } else {
            $jobStatus->update([
                'status' => '4',
                'error_message' => 'One or more notifications failed to send.',
            ]);
        }
    }

    public function failed(Exception $exception)
    {

        JobStatus::where('job_id', $this->job->getJobId())->update([
            'status' => '4',
            'error_message' => $exception->getMessage(),
        ]);
    }
}