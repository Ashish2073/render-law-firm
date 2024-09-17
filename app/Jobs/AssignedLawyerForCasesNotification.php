<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\CustomerCase;
use App\Models\Customer;
use App\Models\Lawyer;
use Illuminate\Support\Facades\Log;
use Google_Client;
use GuzzleHttp\Client;
use Exception;


class AssignedLawyerForCasesNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    protected $lawyerId;
    protected $caseIds;


    public function __construct($lawyerId, $caseIds)
    {
        $this->lawyerId = $lawyerId;
        $this->caseIds = $caseIds;

       

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Starting job for lawyer', ['lawyerId' => $this->lawyerId, 'cases' => $this->caseIds]);
        $lawyer = Lawyer::find($this->lawyerId);

        CustomerCase::whereIn('id', $this->caseIds)->chunkById(100, function ($cases) use ($lawyer) {


            foreach ($cases as $case) {


                $case->assign_lawyer_id = (int) $this->lawyerId;
                $case->save();

                $batchSize = 100;
                Customer::whereHas('fcm_token')
                    ->where('id', $case->customer_id)
                    ->with('fcm_token')
                    ->chunk($batchSize, function ($customers) use ($lawyer, $case) {
                        $customers->each(function ($customer) use ($lawyer, $case) {

                            $customer->fcm_token->each(function ($fcmToken) use ($customer, $lawyer, $case) {

                                $token = $fcmToken->fcm_token;

                                $lawyer_name = $lawyer->name;


                                $serviceAccountKeyFilePath = public_path('render-law-firm-b1141-firebase-adminsdk-c6hk8-57d9ee4c14.json');

                                $client = new Google_Client();
                                $client->setAuthConfig($serviceAccountKeyFilePath);
                                $client->setScopes([env('GOOGLE_NOTIFICATION_AUTH_API_URL')]);
                                $client->fetchAccessTokenWithAssertion();
                                $accessToken = $client->getAccessToken()['access_token'];
                                $url = 'https://fcm.googleapis.com/v1/projects/render-law-firm-b1141/messages:send';
                                $client = new Client();


                                $payload = [
                                    'message' => [
                                        'token' =>$token,
                                        'notification' => [
                                            'body' => 'Lawyer Assigned to Your Case',
                                            'title' => "Lawyer {$lawyer_name} has been assigned to case {$case->id}.",
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



                                } catch (Exception $e) {
                                    Log::error($e->getMessage());
                                    Log::info('Failed to send notification', [
                                        'error' => $e->getMessage(),

                                    ]);



                                }


                               
                            });
                        });
                    });


            }
        });


    }

    
}
