<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CaseUser;
use App\Models\CaseFile;
use App\Models\CustomerCase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;



class CaseController extends Controller
{
    public function caseFieldCustomerProfileDetailSave(Request $request)
    {

        try {


         
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'customer_id' => 'required|exists:customers,id',
                'email' => 'required|string|email|max:255|unique:case_users,email',
                'phone' => 'required|string|max:15',
                'address' => 'required|string|max:255',
                'zipcode' => 'required|string|max:10',
                'country_id' => 'required|exists:countries,id',
                'state_id' => 'required|exists:states,id',
                'city_id' => 'required|exists:cities,id',
                'details' => 'max:1000',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors(), 
                ], 422);
            }



          
            $customerProfileDetail = new CaseUser();

            $customerProfileDetail->name = $request->name;
            $customerProfileDetail->customer_id = $request->customer_id;
            $customerProfileDetail->email = $request->email;
            $customerProfileDetail->phone = $request->phone;
            $customerProfileDetail->address = $request->address;
            $customerProfileDetail->zipcode = $request->zipcode;
            $customerProfileDetail->country_id = $request->country_id;
            $customerProfileDetail->state_id = $request->state_id;
            $customerProfileDetail->city_id = $request->city_id;
            $customerProfileDetail->details = $request->details;

            $customerProfileDetail->save();

            return response()->json([
                'id' => $customerProfileDetail->id,
                'status' => true,
                'message' => 'Accuser basic infornation save successfully for particuler case'
            ], 200);



        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);

        }

    }



    public function caseDetailSaveByCustomer(Request $request)
    {

        try {

            DB::beginTransaction();


            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'case_type' => 'required|exists:proficiencies,id',
                'case_file.*' => 'mimes:jpg,jpeg,png,gif,pdf,svg,doc,docx|max:6048',
                'customer_id' => 'required|exists:customers,id',
                'case_user_id' => 'required|exists:case_users,id',
                'preferred_attorney_id' => 'required|exists:lawyers,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $customerCase = new CustomerCase();

            $customerCase->title = $request->title;

            $customerCase->case_type = $request->case_type;

            $customerCase->customer_id = $request->customer_id;

            $customerCase->case_user_id = $request->case_user_id;

            $customerCase->preferred_attorney_id = $request->preferred_attorney_id;

            $customerCase->case_urgency_level = $request->case_urgency_level;

            $customerCase->requirement_details = $request->requirement_details;

            $customerCase->save();


            if ($request->hasFile('case_file')) {
                $case_file_name = [];
                foreach ($request->file('case_file') as $k => $image) {

                    

                    $file = $image;
                    $resizeWidth = 200;
                    $resizeHeight = 200;
                    $destinationPath = public_path('cases_file/');

                 

                    $fileName = saveResizedImage($file, $resizeWidth, $resizeHeight, $destinationPath);

                    $case_file_name[$k]['case_id'] = $customerCase->id;
                    $case_file_name[$k]['file_name'] = $fileName;

                }



                CaseFile::upsert($case_file_name, ['case_id'], ['file_name']);



            }

            DB::commit();

            return response()->json([
                'id' => $customerCase->id,
                'status' => true,
                'message' => 'field customer case save successfully'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }



    }


    public function caseFieldCustomerProfileDetailUpdate(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:case_users,email,' . $request->id, 
                'phone' => 'required|string|max:15',
                'address' => 'required|string|max:255',
                'zipcode' => 'required|string|max:10',
                'country_id' => 'required|exists:countries,id',
                'state_id' => 'required|exists:states,id',
                'city_id' => 'required|exists:cities,id',
                'details' => 'max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Find the existing CaseUser by ID
            $customerProfileDetail = CaseUser::findOrFail($request->id);

            // Update the fields
            $customerProfileDetail->name = $request->name;
            $customerProfileDetail->email = $request->email;
            $customerProfileDetail->phone = $request->phone;
            $customerProfileDetail->address = $request->address;
            $customerProfileDetail->zipcode = $request->zipcode;
            $customerProfileDetail->country_id = $request->country_id;
            $customerProfileDetail->state_id = $request->state_id;
            $customerProfileDetail->city_id = $request->city_id;
            $customerProfileDetail->details = $request->details;

            $customerProfileDetail->save();

            return response()->json([
                'id' => $customerProfileDetail->id,
                'status' => true,
                'message' => 'Customer profile information updated successfully',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }



    public function accuserList(Request $request)
    {

        try {
            $accusers = CaseUser::where('customer_id', $request->get('customer_id'))->select('id', 'name', 'email','phone','address','zipcode','country_id','state_id','city_id',DB::raw('COALESCE(details, "") as details'))->orderBy('id', 'desc')->get();

            return response()->json([
                 'data'=>$accusers

            ]
               
            );


        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }

    }



    public function caseFile(Request $request)
{
    try {
        $customerId = $request->get('customer_id');

        // Fetch cases with files related to the customer
        $caseDetails = CustomerCase::with('caseFiles')
            ->where('customer_id', $customerId)->orderBy('id','desc')
            ->get()
            ->map(function ($case) {
                return [
                    'title' => $case->title,
                    'case_files' => $case->caseFiles->map(function ($file) {
                        return [
                            'file_name' => $file->file_name,
                            'file_url' => asset('cases_file/' . $file->file_name)
                        ];
                    })
                ];
            });

        return response()->json([
            'data' => $caseDetails
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
        ], 500);
    }
}




}
