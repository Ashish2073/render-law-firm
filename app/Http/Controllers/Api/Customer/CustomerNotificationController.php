<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Jobs\SendPushNotificationToCustomer;
use Illuminate\Http\Request, Response;
use App\Repositories\CustomerRepository;
use Illuminate\Support\Facades\Validator;
use App\Models\Bookmark;
use App\Models\WelcomeMessage;
use App\Models\Customer;
use App\Models\Lawyer;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\CustomerFcmToken;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Laravel\Facades\Image;



class CustomerNotificationController extends Controller
{
    public function __construct(protected CustomerRepository $customerRepository)
    {
    }


    public function storeCustomerFcmToken(Request $request)
    {
        // try {

        //     $validator = Validator::make($request->all(), [
        //         'fcm_token' => 'required',
        //     ]);

        //     if ($validator->fails()) {
        //         return response()->json([
        //             'status' => false,
        //             'message' => 'Validation errors',
        //             'errors' => $validator->errors(),
        //         ], 422);
        //     }



        //     $customerGetById = $this->customerRepository->find($request->id);



        //     if (!$customerGetById) {
        //         return response()->json([
        //             'status' => false,
        //             'message' => 'Validation errors',
        //             'errors' => 'User Not Found',
        //         ], 422);

        //     }




        //     $customerDeviceToken = $this->customerRepository->updateWhere($request->id, 'id', ['fcm_token' => $request->fcm_token]);

        //     if ($customerDeviceToken) {
        //         return response()->json([
        //             'status' => true,
        //             'message' => 'User Fcm Token Save Successfully',

        //         ], 200);
        //     }



        // } catch (\Exception $e) {

        //     return response()->json([
        //         'status' => 'error',
        //         'message' => $e->getMessage(),
        //     ], 500);

        // }

        try {


            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:customers,id',
                'fcm_token' => 'required',

            ]);

         

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors(),
                ], 422);
            }


            $customerId = $request->id;
            $fcm_token = $request->fcm_token;
         




            $customerFcmToken = CustomerFcmToken::updateOrCreate(
                [
                    'customer_id' => $customerId,
                    'fcm_token' => $fcm_token,
                ]

            );





            if ($customerFcmToken) {
                return response()->json([
                    'status' => true,
                    'message' => 'Customer Fcm Token Save Successfully',

                ], 200);
            }





        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);


        }








    }



    public function customerBookmarkSave(Request $request)
    {
        try {






            $validator = Validator::make($request->all(), [
                'customer_id' => 'required|exists:customers,id',
                'lawyer_id' => 'required'

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors(),
                ], 422);
            }


            $customerId = $request->customer_id;
            $bookMarkLawyers = $request->lawyer_id;




            $bookMark = Bookmark::updateOrCreate(
                [
                    'customer_id' => $customerId,
                    'lawyer_id' => $bookMarkLawyers,
                ],

            );





            return response()->json([
                'status' => true,
                'bookmark' => $bookMark
            ], 200);




        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);


        }
    }


    public function customerBookmarklist(Request $request)
    {
        try {



            $validator = Validator::make($request->all(), [
                'customer_id' => 'required|exists:customers,id',


            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors(),
                ], 422);
            }


            $customerId = $request->get('customer_id');



            $customerBookMark = Bookmark::join('lawyers', 'bookmarks.lawyer_id', '=', 'lawyers.id')
                ->join('customers', 'customers.id', '=', 'bookmarks.customer_id')
                ->select(
                    'lawyer_id',
                    'bookmarks.id as bookmark_id',
                    'customers.id as customer_id',
                    'lawyers.name as name',
                    DB::raw('COALESCE(lawyers.experience, "") as experience'),
                    'lawyers.avg_rating as avgrating',
                    'lawyers.email as email',
                    DB::raw('COALESCE(lawyers.phone_no, "") as phoneno'),
                    DB::raw('COALESCE(lawyers.description_bio, "") as descriptionbio'),
                    DB::raw('COALESCE(lawyers.profile_image, "") as profile_image'),
                )
                ->where('customer_id', $customerId)
                ->get();

            return response()->json([
                'status' => true,
                'customerbookmark' => $customerBookMark
            ], 200);




        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);


        }
    }


    public function customerBookmarkRemove(Request $request)
    {



        $validator = Validator::make($request->all(), [
            'bookmark_id' => 'required|exists:bookmarks,id',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }


        $removeBookMarkItem = Bookmark::where('id', $request->bookmark_id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'lawyer removed your bookmarks'
        ], 200);







    }


    public function customerWelcomeMessage()
    {

        $welcomeMessage = WelcomeMessage::where('status', '=', 1)->select('title', 'content', DB::raw("CONCAT('" . asset('') . 'welcome_message/images/' . "', image) as image"))->get();

        return response()->json([
            'status' => true,
            'data' => $welcomeMessage
        ], 200);

    }



    public function faqList()
    {
        $faq = FaqCategory::with([
            'faq' => function ($query) {
                $query->select('faqs.id as id', 'faqs.question as question', 'faqs.answer as answer')->where('faqs.status', '=', '1');
            }
        ])
            ->has('faq')

            ->get();

        return response()->json([
            'status' => true,
            'data' => $faq
        ], 200);


    }




}