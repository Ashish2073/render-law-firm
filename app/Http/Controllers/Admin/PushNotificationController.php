<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerCase;
use Illuminate\Support\Facades\Hash;
use App\Models\PushNotification;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendPushNotificationToCustomer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Google_Client;
use GuzzleHttp\Client;


class PushNotificationController extends Controller
{
    public function sendNotificationAllUsers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $validator->sometimes('notification_image', 'image|mimes:jpg,jpeg,png,gif,svg|max:6048', function ($request) {
            return isset($request->jobID);
        });


        if ($validator->fails()) {
            return response()->json([
                'sucess' => false,
                'errormessage' => $validator->errors(),


            ], 422);


        }


        if (!isset($request->jobId)) {

            $pushNotification = new PushNotification();

            $pushNotification->title = $request->title;
            $pushNotification->description = $request->description;

            if ($request->hasFile('notification_image')) {

                $file = $request->file('notification_image');
                $resizeWidth = 200;
                $resizeHeight = 200;
                $destinationPath = public_path('notification_image');

                $fileName = saveResizedImage($file, $resizeWidth, $resizeHeight, $destinationPath);


                $pushNotification->notification_image = $fileName;


            }

            $pushNotification->save();
        } else {
            $pushNotification = PushNotification::find($request->id);
        }


        // $batchSize = 1000; 

        // Customer::chunk($batchSize, function ($customers) use ($request) {

        //     SendPushNotificationToCustomer::dispatch($customers, $request->title, $request->description);
        // });

        $batchSize = 1000;

        //  Customer::whereNotNull('fcm_token') // Filter customers with non-null fcm_token
        //         ->where('fcm_token', '!=', '') // Ensure the token is not an empty string
        //       ->chunk($batchSize, function ($customers) use ($request) {
        //         // Dispatch the event for the filtered customers
        //         SendPushNotificationToCustomer::dispatch($customers, $request->title, $request->description);
        //         });


        $batchSize = 1000;

        Customer::whereHas('fcm_token') // Ensure customers have related fcm_token entries
            ->with('fcm_token') // Eager load the fcm_token relation
            ->chunk($batchSize, function ($customers) use ($request, $pushNotification) {
                // Iterate over each customer and collect their fcm_tokens along with customer_id
                $fcmTokensWithCustomerIds = $customers->flatMap(function ($customer) {
                    return $customer->fcm_token->map(function ($fcmToken) use ($customer) {
                        return [
                            'fcm_token' => $fcmToken->fcm_token,
                            'customer_id' => $customer->id
                        ];
                    });
                })->filter(function ($item) {
                    return !empty($item['fcm_token']); // Ensure only valid tokens are collected
                });

                if ($fcmTokensWithCustomerIds->isNotEmpty()) {
                    // Dispatch the event with the collected fcm_tokens and customer_ids
                    SendPushNotificationToCustomer::dispatch($fcmTokensWithCustomerIds, $request->title, $request->description, $pushNotification->id, $request->jobId ?? null, $pushNotification->notification_image ?? null);
                }
            });

        return response()->json(['message' => 'Notifications are being sent.']);



    }





    // public function index(Request $request)
    // {

    //     if ($request->ajax()) {

    //         if ((session('permissionerror'))) {
    //             return response()->json(['errorpermissionmessage' => session('permissionerror')]);

    //         }



    //         // $customerCases = PushNotification::query() 
    //         ///1-pending,2-completed,3-Not Send To All Users,4-failed
    //         //     ->select('cases.*', \DB::raw("DATE_FORMAT(cases.created_at ,'%d/%m/%Y') AS created_date"))
    //         //     ->orderBy('cases.created_at', 'desc');

    //         $pushNotification = PushNotification::query()->join('job_status', 'push_notifications.id', '=', 'job_status.push_notification_id')
    //             ->select(
    //                 'push_notifications.title',
    //                 'push_notifications.id as id',
    //                 'push_notifications.description',
    //                 'push_notifications.notification_image as notification_image',
    //                 'job_status.id as job_id',
    //                 'job_status.status as status'

    //             );



    //         return datatables()->of($pushNotification)
    //             ->addColumn('notification_image', function ($row) {
    //                 if (isset($row->notification_image)) {
    //                     $url = asset("notification_image/{$row->notification_image}");
    //                 } else {
    //                     $url = asset("defaultimage.png");
    //                 }


    //                 $notification_image = "<div class='position-relative d-inline-block'onmouseover='onMouseOveractionOnImage($row->id)' onmouseout='onMouseOutactionOnImage($row->id)' style='margin: 30px 0px;'>
    //             <img src={$url} id='pushnotificationimage{$row->id}' width='70'  height='70' />
    //             <div class='menu position-absolute  bg-transparent text-black  z-3 rounded d-none d-flex gap-3'  id='menu$row->id' style='margin: 0px -8px;'>    
    //                  <div class='menu-item'><button type='button' class='edit btn btn-success' onclick='ImageView($row->id)'><i class='fa fa-eye'></i></button></div>
    //                  </div>
    //                  </div>       
    //             ";

    //                 return $notification_image;
    //             })



    //             // fas fa-comment-alt     ///1-pending,2-completed,3-Not Send To All Users,4-failed
    //             ->addColumn('status', function ($row) {

    //                 switch ($row->status) {
    //                     case 1:
    //                         $status_text = 'Pending';
    //                         $status_btn = 'btn btn-warning';
    //                         break;
    //                     case 2:
    //                         $status_text = 'Completed';
    //                         $status_btn = 'btn btn-success';
    //                         break;
    //                     case 3:
    //                         $status_text = 'Some user device pending';
    //                         $status_btn = 'btn btn-info';
    //                         break;
    //                     case 4:
    //                         $status_text = 'Failed';
    //                         $status_btn = 'btn btn-warning';
    //                         break;
    //                     default:
    //                         $status_text = 'Unknown';
    //                         $status_btn = 'btn btn-secondary';
    //                         break;
    //                 }



    //                 $notification_status = "<button type='button'
    //                 class='$status_btn'>$status_text</button>";

    //                 return $notification_status;

    //             })


    //             ->addColumn('resendpushnotification', function ($row) {



    //                 $resendpushnotification = "<button type='button' onClick='resendPushNotification($row->job_id)'><i class='fa fa-refresh' style='font-size:36px;'></i></button>";

    //                 return $resendpushnotification;

    //             })


    //             ->rawColumns(['notification_image', 'status', 'resendpushnotification'])
    //             ->make(true);

    //     } else {
    //         return view('cases.index');
    //     }

    // }





    public function notificationShow(Request $request)
    {

        if ($request->ajax()) {

            if ((session('permissionerror'))) {
                return response()->json(['errorpermissionmessage' => session('permissionerror')]);

            }



            // $customerCases = PushNotification::query() 
            ///1-pending,2-completed,3-Not Send To All Users,4-failed
            //     ->select('cases.*', \DB::raw("DATE_FORMAT(cases.created_at ,'%d/%m/%Y') AS created_date"))
            //     ->orderBy('cases.created_at', 'desc');

            $pushNotification = PushNotification::query()->join('job_status', 'push_notifications.id', '=', 'job_status.push_notification_id')
                ->select(
                    'push_notifications.title',
                    'push_notifications.id as id',
                    'push_notifications.description as description',
                    'push_notifications.notification_image as notification_image',
                    'job_status.id as job_id',
                    'job_status.status as status'

                )->orderBy('push_notifications.created_at','desc');






            return datatables()->of($pushNotification)
                ->addIndexColumn()
                ->addColumn('notification_image', function ($row) {
                    if (isset($row->notification_image)) {
                        $url = asset("notification_image/{$row->notification_image}");
                    } else {
                        $url = asset("defaultimage.png");
                    }


                    $notification_image = "<div class='position-relative d-inline-block'onmouseover='onMouseOveractionOnImage($row->id)' onmouseout='onMouseOutactionOnImage($row->id)' style='margin: 30px 0px;'>
                                    <img src={$url} id='pushnotificationimage{$row->id}' width='70'  height='70' />
                                    <div class='menu position-absolute  bg-transparent text-black  z-3 rounded d-none d-flex gap-3'  id='menu$row->id' style='margin: 0px -8px;'>    
                                    <div class='menu-item'><button type='button' class='edit btn btn-success' onclick='ImageView($row->id)'><i class='fa fa-eye'></i></button></div>
                                   </div>
                                   </div>       
                                     ";

                    return $notification_image;
                })



                // fas fa-comment-alt     ///1-pending,2-completed,3-Not Send To All Users,4-failed
                ->addColumn('status', function ($row) {

                    switch ($row->status) {
                        case 1:
                            $status_text = 'Pending';
                            $status_btn = 'btn btn-warning';
                            break;
                        case 2:
                            $status_text = 'Completed';
                            $status_btn = 'btn btn-success';
                            break;
                        case 3:
                            $status_text = 'Some user device pending';
                            $status_btn = 'btn btn-info';
                            break;
                        case 4:
                            $status_text = 'Failed';
                            $status_btn = 'btn btn-danger';
                            break;
                        default:
                            $status_text = 'Unknown';
                            $status_btn = 'btn btn-secondary';
                            break;
                    }



                    $notification_status = "<button type='button'
                    class='$status_btn'>$status_text</button>";

                    return $notification_status;

                })


                ->addColumn('resendpushnotification', function ($row) {



                    $resendpushnotification = "<button type='button' onClick='resendPushNotification($row->job_id,$row->id)'><i class='fa fa-refresh'></i></button>";

                    return $resendpushnotification;

                })


                ->rawColumns(['notification_image', 'status', 'resendpushnotification'])
                ->make(true);

        } else {
            return view('pushnotification.index');
        }


    }


}