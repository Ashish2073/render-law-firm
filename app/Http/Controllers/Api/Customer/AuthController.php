<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request, Response;
use App\Events\SendOtpVarificationMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPasswordOtpMail;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;
use App\Mail\SocialMediaLoginCustomerCredentialMail;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Laravel\Facades\Image;

use Illuminate\Support\Str;


class AuthController extends Controller
{

    function generateComplexPassword($length = 10)
    {
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $specialChars = '@$!%*?&';

        $allChars = $lowercase . $uppercase . $numbers . $specialChars;


        $password = [
            $lowercase[rand(0, strlen($lowercase) - 1)],
            $uppercase[rand(0, strlen($uppercase) - 1)],
            $numbers[rand(0, strlen($numbers) - 1)],
            $specialChars[rand(0, strlen($specialChars) - 1)],
        ];


        for ($i = 4; $i < $length; $i++) {
            $password[] = $allChars[rand(0, strlen($allChars) - 1)];
        }



        return implode('', $password);
    }
    public function customerRegistertion(Request $request)
    {
        try {

            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255|unique:customers,email',
                'name' => 'required|string',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errormessage' => $validator->errors(),
                ], 422);
            }



            $customerData = Customer::create([
                'email' => $request->email,
                'name' => $request->name,
                'password' => Hash::make($request->password),
            ]);

            if ($customerData) {
                $otp = rand(1000, 9999);
                event(new SendOtpVarificationMail($otp, $customerData,Customer::class));

                DB::commit();

                return response()->json([
                    'success' => true,
                    'customerdata' => $customerData,
                ], 201);
            } else {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Customer registration failed.',
                ], 500);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }



    public function customerOtpVarification(Request $request)
    {


        try {

            $customerOtp = Customer::where('otp', $request->otp)->where('email', $request->email)->first();

            if ($customerOtp->is_verified == "1") {
                return response()->json(['success' => false, 'msg' => 'Your Profile is already varified'], 422);
            }

            if (!$customerOtp) {
                return response()->json(['success' => false, 'msg' => 'You entered wrong OTP'], 422);
            } else {


                $currentTime = Carbon::now();


                $otpCreatedAt = Carbon::parse($customerOtp->otp_created_at);
                $differenceInSeconds = abs($currentTime->diffInSeconds($otpCreatedAt));





                if ($currentTime->greaterThanOrEqualTo($otpCreatedAt) && $differenceInSeconds <= 120) {


                    Customer::where('id', $customerOtp->id)->update([
                        'is_verified' => '1',
                        'otp' => null,
                        'otp_verified_at' => Carbon::now(),
                        'email_verified_at' => Carbon::now()
                    ]);




                    $token = $customerOtp->createToken('authToken')->plainTextToken;

                    return response()->json([
                        'success' => true,
                        'msg' => 'Mail has been verified',
                        'token' => $token
                    ], 200);

                } else {
                    return response()->json(['success' => false, 'msg' => 'Your OTP has been Expired'], 422);
                }

            }

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);

        }

    }




    public function resendOtp(Request $request)
    {
        try {
            $customer = Customer::where('email', $request->email)->first();

            if (!$customer) {
                return response()->json(['success' => false, 'msg' => 'Customer not found'], 404);
            }

            // if ($customer->is_verified == "1") {
            //     return response()->json(['success' => false, 'msg' => 'Your Profile is already varified'], 422);
            // }

            $currentTime = Carbon::now();
            $otpCreatedAt = Carbon::parse($customer->otp_created_at);
            $differenceInSeconds = $currentTime->diffInSeconds($otpCreatedAt);

            if (abs($differenceInSeconds) <= 120) {
                return response()->json(['success' => false, 'msg' => 'OTP resend request too soon. Please wait before requesting a new OTP.'], 422);
            }


            $otp = rand(1000, 9999);

            event(new SendOtpVarificationMail($otp, $customer,Customer::class));



            return response()->json(['success' => true, 'msg' => 'OTP has been resent'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }






    public function customerLogin(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $email = $request->input('email');
            $key = 'login-attempts:' . $email;


            if (RateLimiter::tooManyAttempts($key, 5)) {
                return response()->json([
                    'status' => 429,
                    'message' => 'Too many login attempts. Please try again in ' . RateLimiter::availableIn($key) . ' seconds.',

                ], 429);
            }


            $customer = Customer::where('email', $email)->first();

            if (!$customer) {

                RateLimiter::hit($key, 120);
                return response()->json([
                    'status' => false,
                    'message' => 'Customer not found',
                ], 404);
            }


            if ($customer->status == "0") {
                RateLimiter::hit($key, 120);
                return response()->json([
                    'status' => 'deactive',
                    'message' => 'Your Account is Deactivate Please Contact To Admin',
                ], 200);
            }


            if ($customer->is_verified == "0") {
                $this->resendOtp($request);
                return response()->json([
                    'status' => false,
                    'message' => 'Customer not verified, OTP resent',
                ], 200);
            }


            if (!Hash::check($request->password, $customer->password)) {

                RateLimiter::hit($key, 120);
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid credentials',
                ], 401);
            }


            RateLimiter::clear($key);


            $token = $customer->createToken('authToken')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'customerdata' => $customer,
                'token' => $token,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function forgotPassword(Request $request)
    {



        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errormessage' => $validator->errors(),
            ], 422);
        }

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $otp = rand(1000, 9999);
        $customer->otp = $otp;
        $customer->otp_created_at = Carbon::now();
        $customer->save();

        Mail::to($customer->email)->send(new ForgotPasswordOtpMail($otp, $customer));

        return response()->json([
            'message' => 'OTP has been sent to your email.',
        ], 200);

    }



    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errormessage' => $validator->errors(),
            ], 422);
        }

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer) {
            return response()->json(['message' => 'Invalid User'], 422);
        }




        $customer->password = Hash::make($request->password);

        $customer->save();

        return response()->json(['message' => 'Password has been reset successfully'], 200);
    }



    public function passwordOtpVarification(Request $request)
    {
        try {

            $customerOtp = Customer::where('otp', $request->otp)->where('email', $request->email)->first();



            if (!$customerOtp) {
                return response()->json(['success' => false, 'msg' => 'You entered wrong OTP'], 422);
            } else {


                $currentTime = Carbon::now();


                $otpCreatedAt = Carbon::parse($customerOtp->otp_created_at);
                $differenceInSeconds = abs($currentTime->diffInSeconds($otpCreatedAt));





                if ($currentTime->greaterThanOrEqualTo($otpCreatedAt) && $differenceInSeconds <= 120) {


                    Customer::where('id', $customerOtp->id)->update([
                        'otp' => null,
                        'otp_verified_at' => Carbon::now()
                    ]);






                    return response()->json([
                        'success' => true,
                        'message' => 'Otp Varified Succesfully',

                    ], 200);

                } else {
                    return response()->json(['success' => false, 'msg' => 'Your OTP has been Expired'], 422);
                }

            }




        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }

    }


    // public function redirectToGoogle()
    // {
    //     return Socialite::driver('google')->stateless()->redirect();
    // }

    public function handleSocialMediaCallback(Request $request)
    {
        try {

            $customer = Customer::where('email', $request->email)->first();





            if (!$customer) {

                $randomPassword = $this->generateComplexPassword();



                $customer = Customer::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'social_media_id' => $request->social_media_id,
                    'email_verified_at' => Carbon::now(),
                    'is_verified' => 1,
                    'password' => Hash::make($randomPassword)

                ]);

                if ($customer) {



                    $token = $customer->createToken('authToken')->plainTextToken;
                    Mail::to($request->email)->send(new SocialMediaLoginCustomerCredentialMail($randomPassword, $request->email));

                    return response()->json(['status' => true, 'token' => $token, 'customer' => $customer, "message" => "Your Credential Sent to your mail Please Update it"], 200);

                }


            } else {

                if (!$customer->social_media_id) {
                    $customer->social_media_id = $request->social_media_id;
                    $customer->save();
                }


            }

            if ($customer->status == 0) {
                return response()->json(['status' => false, 'message' => "Your account is deactivated !Please contact to authority"], 403);
            } else {
                $token = $customer->createToken('authToken')->plainTextToken;
                return response()->json(['token' => $token, 'customer' => $customer], 200);
            }



        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }



    public function customerLogout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }


    public function editProfile(Request $request)
    {

        // dd($request->all());

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'string',
                'profile_image' => 'image|mimes:jpg,jpeg,png,gif',
                'phone_no' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',

            ]);



            if ($validator->fails()) {
                return response()->json([
                    'sucess' => false,
                    'errormessage' => $validator->errors(),


                ], 422);
            }


            $customer = Customer::find($request->id);

            if(isset($request->phone_no)){
                $customer->phone = $request->phone_no;
            }

            if(isset($request->name)){
                $customer->name = $request->name;
            }
           

            if ($request->hasFile('profile_image')) {

                if ($customer->profile_image) {
                    $oldImagePath = public_path('customer_image/' . $customer->profile_image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
    





                $file = $request->file('profile_image');
                $image = Image::read($file); 

                $originName = $request->file('profile_image')->getClientOriginalName() . '-' . time();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->file('profile_image')->getClientOriginalExtension();
                $fileName = $fileName . '__' . time() . '.' . $extension;
    
                $destinationPathThumbnail = public_path('customer_image/');
                $image->resize(200, 200);
                $image->save($destinationPathThumbnail . $fileName);
                $customer->profile_image = $fileName;


              


                
            }



            $customer->save();


            return response()->json([
                'status'=>true,
                'customer'=>$customer,
                'profile_image_url'=>asset("profile_image".'/'.$customer->profile_image)
            ]);





        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }

    }







}
