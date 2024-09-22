<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerCase;
use App\Jobs\AssignedLawyerForCasesNotification;
use App\Models\Customer;
use App\Models\Plaintiff;
use App\Models\Lawyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use App\Services\CaseService;


class CaseController extends Controller
{
    protected $caseService;
    protected $proficienceRepository;

    public function __construct(CaseService $caseService, ProficienceRepository $proficienceRepository)
    {
        $this->caseService = $caseService;
        $this->proficienceRepository = $proficienceRepository;
    }



    public function index(Request $request)
    {

        if ($request->ajax()) {

            if ((session('permissionerror'))) {
                return response()->json(['errorpermissionmessage' => session('permissionerror')], 403);

            }

            $customerCases = CustomerCase::query()
                ->with('caseFiles') // Eager loading the caseFiles relation
                ->leftJoin('customers', 'cases.customer_id', '=', 'customers.id')
                ->leftJoin('lawyers', 'cases.assign_lawyer_id', '=', 'lawyers.id')
                ->leftJoin('case_users', 'cases.case_user_id', '=', 'case_users.id')
                ->select(
                    'cases.*',
                    \DB::raw("DATE_FORMAT(cases.created_at ,'%d/%m/%Y') AS created_date"),
                    \DB::raw("COALESCE(customers.name, 'N/A') AS customer_name"),
                    'customers.profile_image as customer_profile_image',
                    \DB::raw("COALESCE(lawyers.name, 'Not Assigned') AS lawyer_name"),
                    'lawyers.profile_image as lawyer_profile_image',
                    \DB::raw("COALESCE(case_users.name, 'N/A') AS case_users_name")
                )
                ->orderBy('cases.created_at', 'desc');









            return datatables()->of($customerCases)
                ->addIndexColumn()
                ->addColumn('case_checkbox', function ($row) {
                    return "<input class='case-checkbox' hidden name='case_id[]' id='case-checkbox-$row->id' type='checkbox' value='$row->id' />";

                })

                ->addColumn('customer', function ($row) {
                    if (isset($row->customer_profile_image)) {
                        $url = asset("customer_image/{$row->customer_profile_image}");
                    } else {
                        $url = asset("customer_image/defaultcustomer.jpg");
                    }


                    $customer = "<div class='d-flex align-items-center'><img src={$url} width='50' alt={$row->customer_name} height='50' class='rounded-circle me-2' /><h6>{$row->customer_name}</h6></div>";

                    return $customer;
                })

                ->addColumn('lawyer', function ($row) {
                    if ($row->lawyer_name != 'Not Assigned') {
                        if (isset($row->lawyer_profile_image)) {
                            $url = asset("lawyer/images/{$row->lawyer_profile_image}");
                        } else {
                            $url = asset("customer_image/defaultcustomer.jpg");
                        }

                        $lawyer = "<div class='d-flex align-items-center'><img src={$url} width='50' alt={$row->lawyer_name} height='50' class='rounded-circle me-2' /><h6>{$row->lawyer_name}</h6></div>";

                        return $lawyer;


                    } else {
                        $lawyer = '<a class="orange-btn">Not Assigned<i class="fas fa-exclamation"></i></a>';
                        return $lawyer;
                    }


                })

                ->addColumn('casedocument', function ($row) {

                    $caseFileList = $row->caseFiles;

                    if (!empty(json_decode($caseFileList))) {

                        $caseFilehtml = '<div class="avatar-group">';

                        $imageName = [];
                        $fileName = [];
                        foreach ($caseFileList as $key => $data) {

                            $fileExtension = strtolower(pathinfo($data->file_name, PATHINFO_EXTENSION));

                            $fileUrl = $data->file_name;

                            $fileName[] = $fileUrl;

                            if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                $imageName[] = $data->file_name;
                            } elseif ($fileExtension == 'pdf') {
                                $imageName[] = asset('pdf-icon.png');
                            } elseif (in_array($fileExtension, ['doc', 'docx'])) {
                                $imageName[] = asset('doc-icon.png');
                            }


                            if ($key < 3) {
                                // Check if the file is an image
                                if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                    $caseFilehtml .= '<div class="avatar">
                                                        <img src="' . $fileUrl . '" loading="lazy" alt="..." class="avatar-img rounded-circle border border-white">
                                                      </div>';
                                } elseif (in_array($fileExtension, ['pdf'])) {
                                    // Display PDF using iframe
                                    $caseFilehtml .= '<div class="avatar">
                                                        <a href="' . $fileUrl . '" download>
                                                            <img src="' . asset('pdf-icon.png') . '" alt="Download file" class="avatar-img rounded-circle border border-white">
                                                        </a>
                                                      </div>';
                                    ;
                                } else {
                                    // For non-image and non-PDF files (like DOCX)
                                    $caseFilehtml .= '<div class="avatar">
                                                        <a href="' . $fileUrl . '" download>
                                                            <img src="' . asset('doc-icon.png') . '" alt="Download file" class="avatar-img rounded-circle border border-white">
                                                        </a>
                                                      </div>';
                                }
                            }
                        }

                        $imageNameJson = json_encode($imageName);
                        $fileExtensionJson = json_encode($fileName);

                        // Display document view icon
                        $caseFilehtml .= '<div class="avatar">
                                            <span class="avatar-title">
                                                <img src="' . asset('documentview.png') . '" alt="..." class="avatar-img" onclick="openImageModal(' . htmlspecialchars($imageNameJson, ENT_QUOTES, 'UTF-8') . ',' . htmlspecialchars($fileExtensionJson, ENT_QUOTES, 'UTF-8') . ')">
                                            </span>
                                          </div>';
                        return $caseFilehtml;

                    } else {
                        return "N/A";
                    }

                })





                // fas fa-comment-alt
                ->addColumn('customercasechat', function ($row) {
                    $customer_case_chat = "<div class='admin-message'  data-id='$row->id' data-toggle='modal' data-target='#dynamic-modal'><i class='fas fa-comment-alt'></i></div>";

                    return $customer_case_chat;

                })


                ->rawColumns(['customercasechat', 'case_checkbox', 'customer', 'lawyer', 'casedocument'])

                ->filterColumn('customer', function ($query, $keyword) {

                    $query->where('customers.name', 'LIKE', "%{$keyword}%");
                })

                ->filterColumn('lawyer', function ($query, $keyword) {

                    $query->where('lawyers.name', 'LIKE', "%{$keyword}%");
                })

                ->make(true);


        } else {
            return view('cases.index');
        }

    }








    public function lawyerAssign(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|array|min:1',
            'id.*' => 'required|exists:cases,id',
            'lawyerId' => 'required|exists:lawyers,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errormessage' => $validator->errors(),
            ], 422);
        }


        $cases = collect($request->id);
        $lawyerId = $request->lawyerId;



        $cases->chunk(100)->map(function ($chunkedCases) use ($lawyerId) {

            return AssignedLawyerForCasesNotification::dispatch($lawyerId, $chunkedCases);
        });


        $lawwyer = Lawyer::find($request->lawyerId);



        if (isset($lawwyer->profile_image)) {
            $url = asset("lawyer/images/{$lawwyer->profile_image}");
        } else {
            $url = asset("customer_image/defaultcustomer.jpg");
        }

        $lawyer = "<img src={$url} width='30' alt={$lawwyer->name} height='50' class='rounded-circle me-2' /> {$lawwyer->name}";







        return response()->json([
            'success' => true,
            'message' => 'Lawyer assigned to selected cases successfully.',
            'id' => $request->id,
            'lawyer' => $lawyer,
        ], 200);
    }








    public function lawyerDissiociate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|array|min:1',
            'id.*' => 'required|exists:cases,id',


        ]);

        if ($validator->fails()) {
            return response()->json([
                'sucess' => false,
                'errormessage' => $validator->errors(),


            ], 422);
        }

        $assignLawyerToCases = CustomerCase::WhereIn('id', $request->id)->update(['assign_lawyer_id' => NULL]);







        return response()->json([
            'success' => true,
            'message' => 'Lawyer remove from case.',
            'id' => $request->id,
            'lawyer' => '<a class="orange-btn">Not Assigned<i class="fas fa-exclamation"></i></a>',
        ], 200);



    }





    public function caseFieldCustomerProfileDetailSave(Request $request)
    {
        $rules = $this->caseService->getProfileValidationRules();
        $rules['customer_id'] = 'required|integer|exists:customers,id';

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->caseService->handleValidationFailure($validator);
        }

        try {
            $customerProfileDetail = $this->caseService->saveCustomerProfileDetail($request->all());

            return $this->caseService->handleSuccessResponse('Customer profile saved successfully.', $customerProfileDetail->id);
        } catch (\Exception $e) {
            return $this->caseService->handleErrorResponse($e->getMessage());
        }
    }










}