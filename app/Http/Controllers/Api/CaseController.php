<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CaseService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class CaseController extends Controller
{
    protected $caseService;

    public function __construct(CaseService $caseService)
    {
        $this->caseService = $caseService;
    }

    protected function handleSuccessResponse($message, $data)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], 200);
    }

    protected function handleErrorResponse($message)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], 500);
    }

    public function caseFieldCustomerProfileDetailSave(Request $request)
    {
        $validator = Validator::make($request->all(), $this->getProfileValidationRules());

        if ($validator->fails()) {
            return $this->handleValidationFailure($validator);
        }

        try {
            $customerProfileDetail = $this->caseService->saveCustomerProfileDetail($request->all());

            return $this->handleSuccessResponse('Customer profile saved successfully.', $customerProfileDetail->id);
        } catch (\Exception $e) {
            return $this->handleErrorResponse($e->getMessage());
        }
    }

    public function caseDetailSaveByCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), $this->getCaseValidationRules());

        if ($validator->fails()) {
            return $this->handleValidationFailure($validator);
        }

        try {
            DB::beginTransaction();

            $customerCase = $this->caseService->saveCaseDetail($request->all());

            if ($request->hasFile('case_file')) {
                $this->caseService->saveCaseFiles($customerCase->id, $request->file('case_file'));
            }

            DB::commit();

            return $this->handleSuccessResponse('Customer case saved successfully.', $customerCase->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->handleErrorResponse($e->getMessage());
        }
    }

    public function accuserList(Request $request)
    {
        try {
            $accusers = $this->caseService->getAccuserList($request->get('customer_id'));
            return $this->handleSuccessResponse('Accuser list retrieved successfully.', $accusers);
        } catch (\Exception $e) {
            return $this->handleErrorResponse($e->getMessage());
        }
    }

    public function caseFile(Request $request)
    {
        try {
            $caseFiles = $this->caseService->getCaseFiles($request->get('customer_id'));
            return $this->handleSuccessResponse('Case files retrieved successfully.', $caseFiles);
        } catch (\Exception $e) {
            return $this->handleErrorResponse($e->getMessage());
        }
    }

    protected function getProfileValidationRules()
    {
        return [
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
        ];
    }

    protected function getCaseValidationRules()
    {
        return [
            'title' => 'required|string|max:255',
            'case_type' => 'required|exists:proficiencies,id',
            'case_file.*' => 'mimes:jpg,jpeg,png,gif,pdf,svg,doc,docx|max:6048',
            'customer_id' => 'required|exists:customers,id',
            'case_user_id' => 'required|exists:case_users,id',
            'preferred_attorney_id' => 'required|exists:lawyers,id',
        ];
    }

    protected function handleValidationFailure($validator)
    {
        return response()->json([
            'status' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors(),
        ], 422);
    }





    public function caseFieldCustomerProfileDetailUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), $this->getProfileUpdateValidationRules($request->id));

        if ($validator->fails()) {
            return $this->handleValidationFailure($validator);
        }

        try {
            $customerProfileDetail = $this->caseService->updateCustomerProfileDetail($request->all());

            return $this->handleSuccessResponse('Customer profile updated successfully.', $customerProfileDetail->id);
        } catch (\Exception $e) {
            return $this->handleErrorResponse($e->getMessage());
        }
    }

    // Other methods...

    protected function getProfileUpdateValidationRules($id)
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:case_users,email,' . $id,
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'zipcode' => 'required|string|max:10',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'details' => 'max:1000',
        ];
    }





}
