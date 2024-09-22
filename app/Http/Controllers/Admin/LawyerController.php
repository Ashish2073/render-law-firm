<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Lawyer;
use App\Events\SendOtpVarificationMail;
use App\Models\Proficience;
use App\Models\LawyerSocialMedia;
use App\Models\LawyerProficiencie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use App\Models\LawyerReview;
use App\Repositories\LawyerRepository;
use App\Mail\LawyerCredentialMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use App\Repositories\ProficienceRepository;


use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class LawyerController extends Controller
{


    protected $lawyerRepository;
    protected $proficienceRepository;

    public function __construct(LawyerRepository $lawyerRepository, ProficienceRepository $proficienceRepository)
    {
        // Inject the CustomerRepository

        $this->lawyerRepository = $lawyerRepository;
        $this->proficienceRepository = $proficienceRepository;
    }


    public function registration(Request $request)
    {

        try {

            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255|unique:lawyers,email',
                'name' => 'required|string',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {

                return back()->withErrors([
                    'error' => $validator->errors()
                ]);
            }



            $lawyerData = Lawyer::create([
                'email' => $request->email,
                'name' => $request->name,
                'password' => Hash::make($request->password),
            ]);

            if ($lawyerData) {


                $otp = rand(1000, 9999);

                event(new SendOtpVarificationMail($otp, $lawyerData, Lawyer::class));

                $newLawyer = Lawyer::where('email', $request->email)->first();

                $otpCreatedAt = $newLawyer->otp_created_at;




                DB::commit();

                return redirect()->to(route('lawyer.otp-verification') . '?email=' . encrypt($lawyerData->email) . '&otp_created_at=' . encrypt($otpCreatedAt));




                // return response()->json([
                //     'success' => true,
                //     'lawyerData' => $lawyerData,
                // ], 201);
            } else {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Lawyer registration failed.',
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




    public function login(Request $request)
    {

        $this->ensureIsNotRateLimited($request);
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {

            return back()->withErrors([
                'error' => $validator->errors()
            ]);
        }

        if (!Auth::guard('lawyer')->attempt($request->only('email', 'password'))) {
            RateLimiter::hit($this->throttleKey($request));
            return back()->withErrors([
                'error' => 'Email or password is incorrect'
            ]);
        }

        $request->session()->regenerate();
        RateLimiter::clear($this->throttleKey($request));

        return redirect()->route('admin.dashboard');


    }

    protected function ensureIsNotRateLimited(Request $request)
    {
        if (RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            throw ValidationException::withMessages([
                'email' => ['Too many login attempts. Please try again later.'],
            ])->status(429);
        }
    }

    protected function throttleKey(Request $request)
    {
        return strtolower($request->input('email')) . '|' . $request->ip();
    }




    public function logout(Request $request)
    {

        Auth::guard('lawyer')->logout();

        $request->session()->invalidate();


        return redirect()->route('lawyer.detail.login');


    }




    public function index(Request $request)
    {

        if ($request->ajax()) {
            $lawyer = Lawyer::query()
                ->with('proficiencies')->orderBy('id', 'desc');

            return datatables()->of($lawyer)
                ->addIndexColumn()

                ->addColumn('lawyer_image', function ($row) {

                    $url = $row->profile_image;



                    $customerimg = "<div class='position-relative d-inline-block'onmouseover='onMouseOveractionOnImage($row->id)' onmouseout='onMouseOutactionOnImage($row->id)' style='margin: 30px 0px;'>
                    <img src={$url} id='lawyerimage{$row->id}' width='70'  height='70' />
                    <div class='menu position-absolute  bg-transparent text-black  z-3 rounded d-none d-flex gap-3'  id='menu$row->id' style='margin: 0px -8px;'>
                          <div class='menu-item mb-1'><button type='button' class='edit btn btn-primary' onclick='lawywerImageEdit($row->id)'><i class='far fa-edit'></i></button></div>
                         <div class='menu-item'><button type='button' class='edit btn btn-success' onclick='lawyerImageView($row->id)'><i class='fa fa-eye'></i></button></div>
                         </div>
                         </div>       
                    ";

                    return $customerimg;
                })
                ->addColumn('feedback_rating', function ($row) {

                    $ratings = LawyerReview::selectRaw("
                    COUNT(CASE WHEN rating BETWEEN 1 AND 1.99 THEN 1 END) AS range_1_to_2,
                    COUNT(CASE WHEN rating BETWEEN 2 AND 2.99 THEN 1 END) AS range_2_to_3,
                    COUNT(CASE WHEN rating BETWEEN 3 AND 3.99 THEN 1 END) AS range_3_to_4,
                    COUNT(CASE WHEN rating BETWEEN 4 AND 5 THEN 1 END) AS range_4_to_5
                    ")
                        ->where('lawyer_id', $row->id)
                        ->first();


                    $showFeedBackIconImage = asset('show-feedback-icon.png');


                    $avg_rating = number_format($row->avg_rating, 2);
                    $rating_count = $row->ratings_count;


                    $stars_html = '<div class="d-flex align-items-center">';


                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $avg_rating) {

                            $stars_html .= "<i class='fas fa-star' style='color: #FFD700;'></i>";
                        } else {

                            $stars_html .= "<i class='far fa-star' style='color: #FFD700;'></i>";
                        }
                    }


                    $stars_html .= "<i class='fas fa-users ms-2 me-1' style='color: #000;'></i> <span>({$rating_count})</span>";


                    $stars_html .= '</div>';


                    $feedback_rating_html = "
                        <div class='d-flex align-items-start'>
                           
                            <div>
                                <h6>Average Rating: {$avg_rating}</h6>
                                <div class='d-flex align-items-center'>
                                    {$stars_html}
                                </div>
                            </div>
                             <img src='{$showFeedBackIconImage}' onclick='openModalFeddBackReview($row->id,$avg_rating,$rating_count,$ratings)' width='50' alt='{$row->customer_name}' height='30' class='me-2' />
                        </div>";

                    return $feedback_rating_html;

                })






                ->addColumn('proficiencies', function ($row) {



                    $lawyerProficiencies = $row->proficiencies;

                    if (!empty($lawyerProficiencies) && count($lawyerProficiencies) > 0) {

                        $proficienciesHtml = '<ul>';
                        foreach ($lawyerProficiencies as $data) {

                            $proficienciesHtml = $proficienciesHtml . '<li>' . $data->proficience_name . '</li>';

                        }
                        $proficienciesHtml = $proficienciesHtml . '</ul>';

                        return $proficienciesHtml;
                    } else {
                        return "<p>N/A</p>";
                    }




                })




                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex gap-2"><button type="button" id="editLawyer' . $row->id . '" onclick="editLawyer(' . $row->id . ')" class="edit btn btn-primary mr-2" style="margin-right: 5px;"><i class="far fa-edit"></i></button>';
                    $btn .= '<button type="button" onclick="workInProgress(' . $row->id . ')" class="delete btn btn-danger "><i class="fas fa-trash-alt"></i></button></div>';
                    return $btn;
                })

                ->addColumn('status', function ($row) {

                    $status_text = $row->status == 1 ? 'Active' : 'Inactive';

                    $status_btn = $row->status == 1 ? 'btn btn-success' : 'btn btn-danger';

                    $lawyer_status = "<button type='button' id='statuschange$row->id' onclick='changeStatus($row->id)' 
                    class='$status_btn'>$status_text</button>";





                    return $lawyer_status;



                })

                ->addColumn('created_at', function ($row) {


                    $date = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at);


                    $formattedDate = $date->format('d/m/y');


                    return $formattedDate;
                })



                ->rawColumns(['action', 'feedback_rating', 'lawyer_image', 'status', 'proficiencies', 'created_at'])
                ->filterColumn('proficiencies', function ($query, $keyword) {
                    $query->whereHas('proficiencies', function ($query) use ($keyword) {
                        $query->where('proficience_name', 'LIKE', "%{$keyword}%");
                    });
                })
                ->make(true);




        } else {


            $proficience = Proficience::where('parent_id', '=', 0)->select('id', 'proficience_name')->get();

            return view('lawyers.index', ['proficience' => $proficience]);

        }

    }

    public function create()
    {
        return view('lawyers.create');
    }


    public function lawyerStatusUpdate(Request $request)
    {


        $lawyer = Lawyer::find($request->id);
        $lawyer->status = $request->status;

        $lawyer->save();

        return response()->json([
            'id' => $lawyer->id,
            'status' => $lawyer->status,

        ], 200);

    }


    public function lawyerProficienceSave(Request $request)
    {



        $validator = Validator::make($request->all(), [

            'proficience_name' => 'required|string|max:255|unique:proficiencies,proficience_name',
            'parent_id' => 'required'

        ], [
            'parent_id.required' => 'Please select the parent name'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'sucess' => false,
                'errormessage' => $validator->errors(),


            ], 422);

        }


        $proficience = new Proficience();

        $proficience->proficience_name = $request->proficience_name;
        $proficience->parent_id = $request->parent_id;

        $proficience->save();



        if ($proficience) {
            return response()->json([
                'sucess' => true,
                'proficience' => ($proficience->parent_id == 0) ? $proficience : "",
            ], 200);

        }





    }



    public function lawyerSave(Request $request)
    {

        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|string|email|max:255|unique:lawyers,email',
                'profile_image' => 'image|mimes:jpg,jpeg,png,gif,svg',
                'proficienc_ids' => 'required',
                'description_bio' => 'required|max:1000',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                    'regex:/[@$!%*?&#]/' // Must include at least one special character (@$!%*?&#)
                ],
                'phone_no' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
                'experience' => 'required',
                'socialmedianame.*' => 'required',
                'socialmediaurl.*' => 'required',
            ], [
                'socialmedianame.*.required' => 'Social media field required',
                'socialmediaurl.*.required' => 'Social media url required',
                'phone_no.required' => 'A phone number is required',
                'phone_no.regex' => 'Please enter a valid phone number',
                'phone_no.min' => 'The phone number must be at least 10 digits',
                'phone_no.max' => 'The phone number may not be greater than 15 digits',
                'password.regex' => 'The password must contain at least one special character (@$!%*?&#).',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'sucess' => false,
                    'errormessage' => $validator->errors(),


                ], 422);
            }



            $lawyer = new Lawyer();

            $lawyer->name = $request->name;
            $lawyer->experience = $request->experience;
            $lawyer->email = $request->email;
            $lawyer->phone_no = $request->phone_no;
            $lawyer->description_bio = $request->description_bio;
            $lawyer->password = Hash::make($request->password);



            if ($request->hasFile('profile_image')) {

                $file = $request->file('profile_image');




                $file = $request->file('profile_image');
                $resizeWidth = 200;
                $resizeHeight = 200;
                $destinationPath = public_path('lawyer/images/');

                $fileName = saveResizedImage($file, $resizeWidth, $resizeHeight, $destinationPath);


                $lawyer->profile_image = $fileName;
            }




            $lawyer->save();

            if ($lawyer) {

                $lawyer->assignRole('lawyer');

                $lawyerSocialMediaName = $request->socialmedianame;
                $lawyerSocialMediaUrl = $request->socialmediaurl;
                $lawyerSocialMediaDeatils = [];
                foreach ($lawyerSocialMediaName as $k => $value) {
                    $lawyerSocialMediaDeatils[$k]['lawyer_id'] = $lawyer->id;
                    $lawyerSocialMediaDeatils[$k]['social_media_id'] = $value;
                    $lawyerSocialMediaDeatils[$k]['social_media_url'] = $lawyerSocialMediaUrl[$k];


                }

                LawyerSocialMedia::insert($lawyerSocialMediaDeatils);


                $lawyerProficience = $request->proficienc_ids;
                $lawyerProficienceDeatils = [];
                foreach ($lawyerProficience as $k => $value) {
                    $lawyerProficienceDeatils[$k]['lawyer_id'] = $lawyer->id;
                    $lawyerProficienceDeatils[$k]['proficience_id'] = $value;

                }

                LawyerProficiencie::insert($lawyerProficienceDeatils);



            }

            Mail::to($request->email)->send(new LawyerCredentialMail($request->password, $request->email));

            DB::commit();
            return response()->json([
                'lawyer_id' => $lawyer->id,
                'status' => true,
                'message' => 'Lawyer Resistration Happen successfully'
            ]);


        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }




    }



    public function editLawyer(Request $request)
    {

        $lawyer = Lawyer::with(['proficiencies', 'socialmedia'])->where('id', $request->id)->get();



        $lawyerProficience = Lawyer::with(['proficiencies'])->where('id', $request->id)->first();


        $groupedProficiencies = [];


        foreach ($lawyerProficience->proficiencies as $proficience) {
            $parentId = $proficience->parent_id;
            $childId = $proficience->id;

            if (!isset($groupedProficiencies[$parentId])) {
                $groupedProficiencies[$parentId] = [];
            }

            $groupedProficiencies[$parentId][] = $childId;
        }






        $proficience = Proficience::select('id', 'proficience_name')->get();

        $editFormHtml = View::make('lawyers.edit', ['lawyer' => $lawyer, 'proficience' => $proficience, 'groupedProficiencies' => $groupedProficiencies])->render();

        return response()->json([
            'editHtml' => $editFormHtml
        ]);

    }


    public function lawyerUpdate(Request $request)
    {

        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|string|email|max:255|unique:lawyers,email,' . $request->id,
                'profile_image' => 'image|mimes:jpg,jpeg,png,gif,svg|max:6048',
                'proficienc_ids' => 'required',
                'description_bio' => 'required',
                'phone_no' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
                'experience' => 'required',
                'socialmedianame.*' => 'required',
                'socialmediaurl.*' => 'required',
            ], [
                'socialmedianame.*.required' => 'Social media field required',
                'socialmediaurl.*.required' => 'Social media url required',
                'phone_no.required' => 'A phone number is required',
                'phone_no.regex' => 'Please enter a valid phone number',
                'phone_no.min' => 'The phone number must be at least 10 digits',
                'phone_no.max' => 'The phone number may not be greater than 15 digits',
            ]);

            $validator->sometimes('password', 'required|string|min:8|confirmed', function ($input) {
                return !empty($input->password);
            });

            if ($validator->fails()) {
                return response()->json([
                    'sucess' => false,
                    'errormessage' => $validator->errors(),


                ], 422);
            }

            $lawyer = Lawyer::find($request->id);

            $lawyer->name = $request->name;
            $lawyer->experience = $request->experience;
            $lawyer->email = $request->email;

            $lawyer->phone_no = $request->phone_no;
            $lawyer->description_bio = $request->description_bio;

            if (isset($request->password)) {

                $lawyer->password = Hash::make($request->password);
            }



            if ($request->hasFile('profile_image')) {
                // $file = $request->file('profile_image');
                // $image = Image::read($file);



                // $originName = $request->file('profile_image')->getClientOriginalName() . '-' . time();
                // $fileName = pathinfo($originName, PATHINFO_FILENAME);
                // $extension = $request->file('profile_image')->getClientOriginalExtension();
                // $fileName = $fileName . '__' . time() . '.' . $extension;

                // $destinationPathThumbnail = public_path('lawyer/images/');

                // if (!file_exists($destinationPathThumbnail)) {
                //     mkdir($destinationPathThumbnail, 0755, true);
                // }
                // $image->resize(200, 200);
                // $image->save($destinationPathThumbnail . $fileName);

                // $previousImage = $destinationPathThumbnail . $lawyer->profile_image;
                // if (file_exists($previousImage) && $lawyer->profile_image) {
                //     unlink($previousImage);
                // }

                $file = $request->file('profile_image');
                $resizeWidth = 200;
                $resizeHeight = 200;
                $destinationPath = public_path('lawyer/images/');
                $previousImage = $lawyer->profile_image; // Assuming $lawyer is the model instance

                $fileName = updateResizedImage($file, $resizeWidth, $resizeHeight, $destinationPath, $previousImage);

                // Save the new file name to the lawyer's profile image field
                $lawyer->profile_image = $fileName;
            }

            $lawyer->save();

            if ($lawyer) {


                LawyerSocialMedia::where('lawyer_id', $request->id)->delete();
                LawyerProficiencie::where('lawyer_id', $request->id)->delete();


                $lawyerSocialMediaName = $request->socialmedianame;
                $lawyerSocialMediaUrl = $request->socialmediaurl;
                $lawyerSocialMediaDeatils = [];
                foreach ($lawyerSocialMediaName as $k => $value) {
                    $lawyerSocialMediaDeatils[$k]['lawyer_id'] = $lawyer->id;
                    $lawyerSocialMediaDeatils[$k]['social_media_id'] = $value;
                    $lawyerSocialMediaDeatils[$k]['social_media_url'] = $lawyerSocialMediaUrl[$k];


                }

                LawyerSocialMedia::insert($lawyerSocialMediaDeatils);


                $lawyerProficience = $request->proficienc_ids;
                $lawyerProficienceDeatils = [];
                foreach ($lawyerProficience as $k => $value) {
                    $lawyerProficienceDeatils[$k]['lawyer_id'] = $lawyer->id;
                    $lawyerProficienceDeatils[$k]['proficience_id'] = $value;

                }

                LawyerProficiencie::insert($lawyerProficienceDeatils);



            }



            $lawyerDetail = Lawyer::with(['proficiencies', 'socialmedia'])->where('id', $lawyer->id)->get();
            DB::commit();
            return response()->json([
                'status' => true,
                'lawyerDetail' => $lawyerDetail,
                'message' => 'Lawyer Deatils Updated  successfully'
            ]);



        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }

    }


    public function lawyerImageUpdate(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'profile_image' => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:6048',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'sucess' => false,
                'errormessage' => $validator->errors(),


            ], 422);
        }


        $lawyer = Lawyer::find($request->id);


        if ($request->hasFile('profile_image')) {


            $file = $request->file('profile_image');
            $resizeWidth = 200;
            $resizeHeight = 200;
            $destinationPath = public_path('lawyer/images/');
            $previousImage = $lawyer->profile_image; // Assuming $lawyer is the model instance

            $fileName = updateResizedImage($file, $resizeWidth, $resizeHeight, $destinationPath, $previousImage);

            // Save the new file name to the lawyer's profile image field
            $lawyer->profile_image = $fileName;

            // if ($lawyer->profile_image) {
            //     $oldImagePath = public_path('lawyer/images/' . $lawyer->profile_image);
            //     if (file_exists($oldImagePath)) {
            //         unlink($oldImagePath);
            //     }
            // }

            // $file = $request->file('profile_image');


            // $image = Image::read($file);

            // $originName = $request->file('profile_image')->getClientOriginalName() . '-' . time();
            // $fileName = pathinfo($originName, PATHINFO_FILENAME);
            // $extension = $request->file('profile_image')->getClientOriginalExtension();
            // $fileName = $fileName . '__' . time() . '.' . $extension;

            // $destinationPathThumbnail = public_path('lawyer/images/');
            // $image->resize(200, 200);
            // $image->save($destinationPathThumbnail . $fileName);
            // $lawyer->profile_image = $fileName;
        }

        $lawyer->save();


        return response()->json([
            'id' => $lawyer->id,
            'profile_image' => $lawyer->profile_image


        ], 200);


    }


    public function lawyerUpdateName(Request $request)
    {



        $validator = Validator::make($request->all(), [

            'name' => 'required|string',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'sucess' => false,
                'errormessage' => $validator->errors(),


            ], 422);
        }

        $lawyer = Lawyer::find($request->id);

        $lawyer->name = $request->name;

        $lawyer->save();


        return response()->json([
            'success' => true,
            'id' => $lawyer->id,
            'name' => $lawyer->name


        ], 200);


    }



    public function lawyerUpdateEmail(Request $request)
    {



        $validator = Validator::make($request->all(), [

            'email' => 'required|string|email|max:255|unique:lawyers,email,' . $request->id,

        ]);

        if ($validator->fails()) {
            return response()->json([
                'sucess' => false,
                'errormessage' => $validator->errors(),


            ], 422);
        }

        $lawyer = Lawyer::find($request->id);

        $lawyer->email = $request->email;

        $lawyer->save();


        return response()->json([
            'success' => true,
            'id' => $lawyer->id,
            'email' => $lawyer->email


        ], 200);


    }



    public function proficienciesList(Request $request)
    {

        if (request()->ajax()) {


            $records = Proficience::query()->
                with('children')->orderBy('id', 'desc');

            return datatables()->of($records)
                ->addColumn('proficience', function ($row) {
                    return $row->proficience_name;

                })->addIndexColumn()
                ->addColumn('sub_area_of_proficience', function ($row) {

                    if ($row->children->isEmpty()) {
                        return 'N/A';
                    }

                    $html = '<ul>';
                    foreach ($row->children as $child) {
                        $html .= '<li id="' . $child->id . '">' . $child->proficience_name . '</li>';
                    }
                    $html .= '</ul>';

                    return $html;



                })->addIndexColumn()



                ->addColumn('action', function ($row) {
                    $btn = '<button type="button" id="editLawyer' . $row->id . '" onclick="editLawyerProficience(' . $row->id . ')" class="edit btn btn-primary mr-2" style="margin-right: 5px;"><i class="far fa-edit"></i></button>';
                    $btn .= '<button type="button" onclick="deleteLawyerProficience(' . $row->id . ')" class="delete btn btn-danger "><i class="fas fa-trash-alt"></i></button>';
                    return $btn;
                })
                ->rawColumns(['proficience', 'sub_area_of_proficience', 'action'])
                ->filterColumn('proficience', function ($query, $keyword) {
                    $query->where('proficience_name', 'like', "%{$keyword}%");
                })
                ->filterColumn('sub_area_of_proficience', function ($query, $keyword) {
                    $query->whereHas('children', function ($query) use ($keyword) {
                        $query->where('proficience_name', 'LIKE', "%{$keyword}%");
                    });
                })


                ->addIndexColumn()


                ->make(true);

        } else {

            $proficience = Proficience::get();

            return view('lawyers.proficience.index', ['proficience' => $proficience]);
        }

    }



    // public function lawyerProficienceEdit(Request $request)
    // {
    //     
    //     $proficience = Proficience::with('children')->where('id', '=', $request->id)->get();
    //     return response()->json([
    //         'proficience' => $proficience,
    //     ], 200);

    // }


    public function lawyerProficienceEdit(Request $request)
    {
        // Find the parent proficience
        $proficience = Proficience::find($request->id);

        // Get the sub proficiencies (children) for the parent
        $subchilProficience = Proficience::where('parent_id', $request->id)->get();

        // Get all proficiencies excluding the current parent and its parent
        $allProficiences = Proficience::whereNotIn('id', [$request->id, $proficience->parent_id])
            ->where('parent_id', '!=', 0)
            ->get();

        $optionHtml = "<option value=''></option>"; // Initialize the HTML string

        // Generate the options for the select element
        foreach ($allProficiences as $data) {
            // Check if the current proficience is in the selected list of sub-proficiencies
            $selected = $subchilProficience->contains('id', $data->id) ? 'selected' : '';
            $optionHtml .= "<option value='" . $data->id . "' " . $selected . ">" . ($data->proficience_name) . "</option>";
        }

        // Build the final HTML response
        $htmlResponse = '<div class="form-group">
                             <label for="" class="form-label"><h5> Sub Proficiency List </h5></label>
                             <select  class="form-control" multiple style="width:100%" id="child_proficience_list"  
                                 name="sub_proficienc_id[]" aria-label="Default select example">'
            . $optionHtml .
            '</select>
                         </div>';

        // Return the HTML in a JSON response
        return response()->json([
            'html' => $htmlResponse,
        ], 200);
    }





    public function lawyerProficienceUpdate(Request $request)
    {

        \DB::beginTransaction();


        try {
            $validator = Validator::make($request->all(), [
                'parent_name' => 'required|string|unique:proficiencies,proficience_name,' . $request->parent_id . ',id',
            ]);


            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errormessage' => $validator->errors(),
                ], 422);
            }





            $ids = $request->sub_proficienc_id;

            $proficienNameUpdate = Proficience::find($request->parent_id);

            $proficienNameUpdate->proficience_name = $request->parent_name;

            $proficienNameUpdate->save();



            $proficienceParentExist = Proficience::where('parent_id', $request->parent_id)->exists();



            $allchildProficienceRemoveFromParent = Proficience::where('parent_id', $request->parent_id)->update(['parent_id' => 0]);



            if ($allchildProficienceRemoveFromParent || ($proficienceParentExist == false)) {

                Proficience::whereIn('id', $ids)->update([
                    'parent_id' => $request->parent_id
                ]);
            }



            $proficiences = Proficience::with('parent')->whereIn('id', $ids)->get();

            \DB::commit();


            return response()->json([
                'data' => $proficiences,
                'parent_id' => $request->parent_id,
                'parent_name' => $request->parent_name,
            ], 200);

        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }


    public function proficienceListByParent(Request $request)
    {

        $proficiences = Proficience::
            with('parent')->whereIn('parent_id', $request->selectedValues)->get()->groupBy(function ($item) {
                return $item->parent->proficience_name;
            });


        if (json_decode($proficiences) != []) {
            $htmlResponse = "";

            $selectedTexts = [];
            foreach ($proficiences as $key => $proficience) {
                $selectedTexts[] = isset($request->id) ? 'select_edit_' . str_replace(' ', '', $key) : 'select' . str_replace(' ', '', $key);

                $selectElementId = isset($request->id) ? 'select_edit_' . str_replace(' ', '', $key) : 'select' . str_replace(' ', '', $key);

                $selectDivElementId = isset($request->id) ? 'edit_' . str_replace(' ', '', $key) : str_replace(' ', '', $key);

                $selectFunctionName = isset($request->id) ? 'selectSubproficiencecategoryEdit' : 'selectSubproficiencecategory';

                if (json_decode($proficience) != []) {
                    $optionHtml = "<option value=''></option>";
                    foreach ($proficience as $index => $data) {

                        $optionHtml = $optionHtml . "<option value='" . $data->id . "'>" . ucwords($data->proficience_name) . "</option>";


                    }
                    $htmlResponse = $htmlResponse . '<div class="form-group" id="' . $selectDivElementId . '">
                <label for="" class="form-label"> Choose Proficiencies (' . $key . ') ' . 'Category</label>
                <select  multiple="multiple" class="form-control" style="width:100%" onchange="' . $selectFunctionName . '(this)" id="' . $selectElementId . '"
                  name="proficienc_ids[]" aria-label="Default select example">'
                        . $optionHtml .
                        '</select>
                  </div>';



                }

            }

        }








        return response()->json([
            'sucess' => true,
            'id' => $selectedTexts,
            'responsehtml' => $htmlResponse
        ], 200);

    }





    public function lawyerlist(Request $request)
    {
        return $this->lawyerRepository->selectOptionDatalist($request);

    }

    public function proficienceList(Request $request)
    {
        return $this->proficienceRepository->selectOptionDatalist($request);

    }



    public function getFeedbacks(Request $request)
    {
        // Validate that lawyer_id is required and exists in the lawyers table
        $request->validate([
            'lawyer_id' => 'required|integer|exists:lawyers,id',
        ]);

        // Get lawyer_id from the request
        $lawyerId = $request->input('lawyer_id');






        // Fetch the lawyer's reviews and join with customer data
        $lawyerReviews = LawyerReview::join('customers', 'lawyer_ratings.customer_id', '=', 'customers.id') // Assuming `lawyer_ratings.customer_id`
            ->where('lawyer_ratings.lawyer_id', $lawyerId) // Filter by lawyer_id
            ->select(
                'customers.name as customer_name',
                'customers.profile_image as customer_profile_image', // Get image path
                'lawyer_ratings.rating as ratings',
                'lawyer_ratings.review as customer_review',
                'lawyer_ratings.created_at as review_date' // Fetch review date
            )
            ->paginate(5); // Paginate the results (5 items per page, adjust as needed)

        // Modify the results to append the full URL to the profile image and format the review date using Carbon
        $lawyerReviews->getCollection()->transform(function ($review) {
            // Applying the asset() function to the customer profile image
            $review->customer_profile_image = (isset($review->customer_profile_image)) ? asset('customer_image/' . $review->customer_profile_image) : asset('customer_image/defaultcustomer.jpg');

            // Formatting the review date using Carbon for human-readable format
            $review->review_date = Carbon::parse($review->review_date)->diffForHumans();

            return $review;
        });

        // Return the paginated lawyer reviews as JSON
        return response()->json($lawyerReviews);
    }



}