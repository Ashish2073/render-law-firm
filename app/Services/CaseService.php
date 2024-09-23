<?php

namespace App\Services;

use App\Models\CaseUser;
use App\Models\CaseFile;
use App\Models\CustomerCase;
use Illuminate\Support\Facades\DB;

class CaseService
{
    public function handleSuccessResponse($message, $data)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], 200);
    }

    public function handleErrorResponse($message)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], 500);
    }


    public function handleValidationFailure($validator)
    {
        return response()->json([
            'status' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors(),
        ], 422);
    }
    public function saveCustomerProfileDetail($data)
    {
        $customerProfileDetail = new CaseUser();
        $customerProfileDetail->name = $data['name'];
        $customerProfileDetail->customer_id = $data['customer_id'];
        $customerProfileDetail->email = $data['email'];
        $customerProfileDetail->phone = $data['phone'];
        $customerProfileDetail->address = $data['address'];
        $customerProfileDetail->zipcode = $data['zipcode'];
        $customerProfileDetail->country_id = 233;
        $customerProfileDetail->state_id = $data['state_id'];
        $customerProfileDetail->city_id = $data['city_id'];
        $customerProfileDetail->details = $data['details'];
        $customerProfileDetail->save();

        return $customerProfileDetail;
    }

    public function saveCaseDetail($data)
    {
        $customerCase = new CustomerCase();
        $customerCase->title = $data['title'];
        $customerCase->case_type = $data['case_type'];
        $customerCase->customer_id = $data['customer_id'];
        $customerCase->case_user_id = $data['case_user_id'];
        $customerCase->preferred_attorney_id = $data['preferred_attorney_id'];
        $customerCase->case_urgency_level = $data['case_urgency_level'];
        $customerCase->requirement_details = $data['requirement_details'];
        $customerCase->save();

        return $customerCase;
    }

    public function saveCaseFiles($caseId, $files)
    {
        $case_file_name = [];
        foreach ($files as $file) {
            $destinationPath = public_path('cases_file/');
            $fileName = saveResizedImage($file, 200, 200, $destinationPath);
            $case_file_name[] = [
                'case_id' => $caseId,
                'file_name' => $fileName
            ];
        }

        CaseFile::upsert($case_file_name, ['case_id'], ['file_name']);
    }

    public function getAccuserList($customerId)
    {
        return CaseUser::where('customer_id', $customerId)
            ->select('id', 'name', 'email', 'phone', 'address', 'zipcode', 'country_id', 'state_id', 'city_id', DB::raw('COALESCE(details, "") as details'))
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getCaseFiles($customerId)
    {
        return CustomerCase::with('caseFiles')
            ->where('customer_id', $customerId)
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($case) {
                return [
                    'title' => $case->title,
                    'case_files' => $case->caseFiles->map(function ($file) {
                        return [
                            'file_name' => $file->file_name,
                            'file_url' => $file->file_name
                        ];
                    })
                ];
            });
    }


    public function updateCustomerProfileDetail($data)
    {
        // Find the existing CaseUser by ID
        $customerProfileDetail = CaseUser::findOrFail($data['id']);

        // Update the fields
        $customerProfileDetail->name = $data['name'];
        $customerProfileDetail->email = $data['email'];
        $customerProfileDetail->phone = $data['phone'];
        $customerProfileDetail->address = $data['address'];
        $customerProfileDetail->zipcode = $data['zipcode'];
        $customerProfileDetail->country_id = 233;
        $customerProfileDetail->state_id = $data['state_id'];
        $customerProfileDetail->city_id = $data['city_id'];
        $customerProfileDetail->details = $data['details'];

        $customerProfileDetail->save();

        return $customerProfileDetail;
    }




    public function getProfileValidationRules()
    {
        return [
            'name' => 'required|string|max:255',
            'customer_id' => 'required|exists:customers,id',
            'email' => 'required|string|email|max:255|unique:case_users,email',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'zipcode' => 'required|string|max:10',
            // 'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'details' => 'max:1000',
        ];
    }

    public function getCaseValidationRules()
    {
        return [
            'title' => 'required|string|max:255',
            'case_type' => 'required|exists:proficiencies,id',
            'case_file.*' => 'mimes:jpg,jpeg,png,gif,pdf,svg,doc,docx|max:6048',
            'customer_id' => 'required|exists:customers,id',
            'preferred_attorney_id' => 'required|exists:lawyers,id',
        ];
    }

    public function getProfileUpdateValidationRules($id)
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:case_users,email,' . $id,
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'zipcode' => 'required|string|max:10',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'details' => 'max:1000',
        ];
    }



}