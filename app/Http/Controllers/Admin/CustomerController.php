<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use DataTables;
use App\Mail\SocialMediaLoginCustomerCredentialMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;

class CustomerController extends Controller 
{

    // public function __construct()
    // {


    //     $this->middleware('permission:customers_view',['only'=>['customerList']]);


    // }  
    public function customerList(Request $request)
    {

        if ($request->ajax()) {

            if ((session('permissionerror'))) {
                return response()->json(['errorpermissionmessage' => session('permissionerror')]);

            }


            $customers = Customer::query()
                ->select('customers.*', \DB::raw("DATE_FORMAT(customers.created_at ,'%d/%m/%Y') AS created_date"))
                ->orderBy('customers.created_at', 'desc');



            return datatables()->of($customers)
                ->addIndexColumn()
                ->addColumn('customer_image', function ($row) {
                    if (isset($row->profile_image)) {
                        $url = asset("customer_image/{$row->profile_image}");
                    } else {
                        $url = asset("customer_image/defaultcustomer.jpg");
                    }


                    $customerimg = "<img src={$url} width='30'  height='50' />";

                    return $customerimg;
                })

                ->addColumn('status', function ($row) {

                    $status_text = $row->status == 1 ? 'Active' : 'Inactive';

                    $status_btn = $row->status == 1 ? 'btn btn-success' : 'btn btn-danger';

                    $customer_status = "<button type='button' id='statuschange$row->id' onclick='changeStatus($row->id)' 
                    class='$status_btn'>$status_text</button>";





                    return $customer_status;



                })
                ->addColumn('verification_status', function ($row) {

                    $fontIcon = $row->is_verified == 1 ? 'fa fa-check' : 'fa fa-close';

                    $fontIconColor = $row->is_verified == 1 ? 'green' : '#ab3131;';

                    $verified_status = "<i class='$fontIcon' style='font-size:30px;color:  $fontIconColor'></i>";


                    return $verified_status;



                })





#f16702;

                ->rawColumns(['customer_image', 'status', 'verification_status'])
                ->make(true);


        } else {
            return view('customer.index');
        }

    }


    public function customerStatusUpdate(Request $request)
    {


        $customer = Customer::find($request->customerId);
        $customer->status = $request->status;

        $customer->save();

        return response()->json([
            'id' => $customer->id,
            'status' => $customer->status,

        ], 200);

    }

    public function customerSave(Request $request)
    { 

        try {


            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255|unique:customers,email',
                'name' => 'required|string|max:255',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                    'regex:/[@$!%*?&#]/' // Must include at least one special character (@$!%*?&#)
                ],
            ], [
                'password.regex' => 'The password must contain at least one special character (@$!%*?&#).',
            ]);
            

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errormessage' => $validator->errors(),
                ], 422);
            }

            

            $customer = new Customer();
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->is_verified = 1;
            $customer->password = Hash::make($request->password);

            if ($request->hasFile('customer_image')) {

                $file = $request->file('customer_image');
                $file = $request->file('customer_image');
                $resizeWidth = 200;
                $resizeHeight = 200;
                $destinationPath = public_path('customer_image');

                $fileName = saveResizedImage($file, $resizeWidth, $resizeHeight, $destinationPath);


                $customer->profile_image = $fileName;

            }

            $customer->save();
            if($customer){
                Mail::to($request->email)->send(new SocialMediaLoginCustomerCredentialMail($request->password, $request->email));
            }



            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }



    }
}
