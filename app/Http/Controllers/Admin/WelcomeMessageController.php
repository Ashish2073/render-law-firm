<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WelcomeMessage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Laravel\Facades\Image;

class WelcomeMessageController extends Controller
{
    public function messageShow(Request $request)
    {
        if ($request->ajax()) {


            $welcomeMessage = WelcomeMessage::query()->select('id', 'title', 'content', 'image', 'status')->orderBy('id', 'desc');



            return datatables()->of($welcomeMessage)
                ->addIndexColumn()

                ->addColumn('image', function ($row) {
                    if (isset($row->image)) {
                        $url = asset("welcome_message/images/{$row->image}");
                    } else {
                        $url = asset("customer_image/defaultcustomer.jpg");
                    }


                    $welcomeMessageImg = "<div class='position-relative d-inline-block'onmouseover='onMouseOveractionOnImage($row->id)' onmouseout='onMouseOutactionOnImage($row->id)' style='margin: 30px 0px;'>
                    <img src={$url} id='welcomeimage{$row->id}' width='70'  height='70' />
                    <div class='menu position-absolute  bg-transparent text-black  z-3 rounded d-none d-flex gap-3'  id='menu$row->id' style='margin: 0px -8px;'>
                          <div class='menu-item mb-1'><button type='button' class='edit btn btn-primary' onclick='welcomeMessageModalImageEdit($row->id)'><i class='far fa-edit'></i></button></div>
                         <div class='menu-item'><button type='button' class='edit btn btn-success' onclick='welcomeMessageModalImageView($row->id)'><i class='fa fa-eye'></i></button></div>
                         </div>
                         </div>       
                    ";

                    return $welcomeMessageImg;
                })


                ->addColumn('action', function ($row) {

                    $btn = '<div class="d-flex gap-3"><button type="button" id="editwelcomemessage' . $row->id . '" onclick="editWelcomeMessage(' . $row->id . ')" class="edit btn btn-primary"><i class="far fa-edit"></i></button>';

                    $btn .= '<button type="button" onclick="workInProgress(' . $row->id . ')" class="delete btn btn-danger"><i class="fas fa-trash-alt"></i></button>';
                    $btn .= '</div>';

                    return $btn;
                })

                ->addColumn('status', function ($row) {

                    $status_text = $row->status == 1 ? 'Active' : 'Inactive';

                    $status_btn = $row->status == 1 ? 'btn btn-success' : 'btn btn-danger';

                    $welcome_Message_status = "<button type='button' id='statuschange$row->id' onclick='changeStatus($row->id)' 
                    class='$status_btn'>$status_text</button>";





                    return $welcome_Message_status;



                })




                ->rawColumns(['action', 'image', 'status'])

                ->make(true);

        } else {
            return view('welcomemessage.index');
        }

    }



    public function messageSave(Request $request)
    {


    


        if (isset($request->id)) {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|unique:welcome_messages,title,'.$request->id,
                'content' => [
                    'required',
                    'string',
                    function ($attribute, $value, $fail) {
                        $wordCount = str_word_count($value);
                        if ($wordCount > 200) {
                            $fail('The ' . $attribute . ' must not exceed 200 words. Currently, ' . $wordCount . ' words.');
                        }
                    },
                ],
                'welcome_message_image' => 'image|mimes:jpg,jpeg,png,gif,svg|max:8048',


            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|unique:welcome_messages,title',
                'content' => [
                    'required',
                    'string',
                    function ($attribute, $value, $fail) {
                        $wordCount = str_word_count($value);
                        if ($wordCount > 200) {
                            $fail('The ' . $attribute . ' must not exceed 200 words. Currently, ' . $wordCount . ' words.');
                        }
                    },
                ],
                'welcome_message_image' => 'image|mimes:jpg,jpeg,png,gif,svg|max:8048',


            ]);
        }

        if ($validator->fails()) {
            return response()->json([
                'sucess' => false,
                'errormessage' => $validator->errors(),


            ], 422);
        }



    

        if(isset($request->id)) {
        $welcomeMessage = WelcomeMessage::find($request->id);

        }else{
            $welcomeMessage = new WelcomeMessage();
        }

        $welcomeMessage->title = $request->title;
        $welcomeMessage->content = $request->content;




        if ($request->hasFile('welcome_message_image')) {

            $file = $request->file('welcome_message_image');


            $image = Image::read($file);

            $originName = $request->file('welcome_message_image')->getClientOriginalName() . '-' . time();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('welcome_message_image')->getClientOriginalExtension();
            $fileName = $fileName . '__' . time() . '.' . $extension;

            $destinationPathThumbnail = public_path('welcome_message/images/');
            $image->resize(200, 200);
            $image->save($destinationPathThumbnail . $fileName);



            $welcomeMessage->image = $fileName;
        }

        $welcomeMessage->save();

        if ($welcomeMessage) {
            return response()->json([
                'status' => true,
                'message' => 'Welcome Message Save Happen successfully'
            ]);
        }

    }


    public function messageImageUpdate(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'image' => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:6048',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'sucess' => false,
                'errormessage' => $validator->errors(),


            ], 422);
        }


        $welcomeMessage = WelcomeMessage::find($request->id);


        if ($request->hasFile('image')) {

            if ($welcomeMessage->image) {
                $oldImagePath = public_path('welcome_message/images/' . $welcomeMessage->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $file = $request->file('image');


            $image = Image::read($file);

            $originName = $request->file('image')->getClientOriginalName() . '-' . time();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = $fileName . '__' . time() . '.' . $extension;

            $destinationPathThumbnail = public_path('welcome_message/images/');
            $image->resize(200, 200);
            $image->save($destinationPathThumbnail . $fileName);
            $welcomeMessage->image = $fileName;
        }

        $welcomeMessage->save();


        return response()->json([
            'id' => $welcomeMessage->id,
            'image' => $welcomeMessage->image


        ], 200);
    }


    public function welcomeMessageTitleNameUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'title' => 'required|string',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'sucess' => false,
                'errormessage' => $validator->errors(),


            ], 422);
        }

        $welcomeMessage = WelcomeMessage::find($request->id);

        $welcomeMessage->title = $request->title;

        $welcomeMessage->save();


        return response()->json([
            'success' => true,
            'id' => $welcomeMessage->id,
            'title' => $welcomeMessage->title


        ], 200);


    }

    public function welcomeMessageContentUpdate(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'content' => 'required|string',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'sucess' => false,
                'errormessage' => $validator->errors(),


            ], 422);
        }

        $welcomeMessage = WelcomeMessage::find($request->id);

        $welcomeMessage->content = $request->content;

        $welcomeMessage->save();


        return response()->json([
            'success' => true,
            'id' => $welcomeMessage->id,
            'title' => $welcomeMessage->content


        ], 200);


    }


    public function statusUpdate(Request $request)
    {


        $welcomeMessage = WelcomeMessage::find($request->id);
        $welcomeMessage->status = $request->status;

        $welcomeMessage->save();

        return response()->json([
            'id' => $welcomeMessage->id,
            'status' => $welcomeMessage->status,

        ], 200);

    }


}








