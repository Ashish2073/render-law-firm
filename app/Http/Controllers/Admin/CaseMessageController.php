<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Events\SendMessage;
use App\Models\CaseMessage;
use Illuminate\Http\Request;
use App\Models\CaseMessageAttachMent;

use Illuminate\Support\Facades\Validator;
use Intervention\Image\Laravel\Facades\Image;

class CaseMessageController extends Controller
{

	public function index(Request $request,$id)
	{
		if (auth()->check()) {
			if(in_array("admin",json_decode(auth()->user()->getRoleNames()))){
               $userid=auth()->user()->id;

		

               $gaurd='user'; 
			
			   $messageStatis = CaseMessage::where('messenger_id', '!=', $userid)->where('cases_id', '=', $id)->where('guard','!=', $gaurd)->update(['user_message_status' => '1']);		

			}
			
		} 
        if(auth('lawyer')->check()) {

            $userid=auth('lawyer')->user()->id;	
            $gaurd='lawyer';
			$messageStatis = CaseMessage::where('messenger_id', '!=', $userid)->where('cases_id', '=', $id)->where('guard','!=', $gaurd)->update(['lawyer_message_status' => '1']);
		}
		
        if(auth('customer')->check()) {

            $userid=auth('customer')->user()->id;
            
            $gaurd='customer';
			$messageStatis = CaseMessage::where('messenger_id', '!=', $userid)->where('cases_id', '=', $id)->where('guard','!=', $gaurd)->update(['customer_message_status' => '1']);
		}


	 
	

		return view('case_message.index', ['id' => $id, 'gaurd' => $gaurd, 'auth' =>$userid ]);
	}



	public static function sharedAttachment($id)
	{
		$attachments = CaseMessage::where('cases_id', '=', $id)
			->join('case_message_attachments', 'case_messages.id', '=', 'case_message_attachments.message_id')
			->leftJoin('customers', function ($join) {
				$join->on('customers.id', '=', 'case_messages.messenger_id')
					->where('case_messages.guard', '=', 'customer');
			})
			->leftJoin('lawyers', function ($join) {
				$join->on('lawyers.id', '=', 'case_messages.messenger_id')
					->where('case_messages.guard', '=', 'lawyer');
			})
			->leftJoin('users', function ($join) {
				$join->on('users.id', '=', 'case_messages.messenger_id')
					->where('case_messages.guard', '=', 'user');
			})
			->select('case_message_attachments.attachment_file as file', 
			'case_messages.guard as guard_name', 'customers.name as customer_name', 
			'lawyers.name as lawyer_name', 'users.name as user_name', 
			'case_messages.created_at as time')

			->get();

		return $attachments;


	}



	public function showMessages(Request $request, $id)
	{



		$Messages = CaseMessage::query()
			->where('cases_id', '=', $id)
			->leftJoin('customers', function ($join) {
				$join->on('customers.id', '=', 'case_messages.messenger_id')
					->where('case_messages.guard', '=', 'customer');
			})
			->leftJoin('lawyers', function ($join) {
				$join->on('lawyers.id', '=', 'case_messages.messenger_id')
					->where('case_messages.guard', '=', 'lawyer');
			})
			->leftJoin('users', function ($join) {
				$join->on('users.id', '=', 'case_messages.messenger_id')
					->where('case_messages.guard', '=', 'user');
			})

			->leftJoin('case_message_attachments', 'case_messages.id', '=', 'case_message_attachments.message_id')

			->select(
				'users.id as user_id',
				'lawyers.id as lawyer_id',
				'customers.id as customer_id',
				'users.name as user_name',
				'lawyers.name as lawyer_name',
				'customers.name as customer_name',
				'users.profile_image as user_img',
				'customers.profile_image as customer_img',
				'lawyers.profile_image as lawyer_img',
				'case_messages.message',
				'case_messages.created_at as time',
				'case_messages.id as id',
				'case_message_attachments.id as file_id',
				'case_message_attachments.attachment_file as file',
				'case_messages.messenger_id as sent_messenger_id',
				'case_messages.guard as guard'
			)->orderBy('case_messages.id','desc');
		

			


		if (auth('customer')->check()) {
			$logged_id = auth('customer')->user()->id;
			$logged_guard = 'customer';
		} elseif (auth('web')->check()) {
			$logged_id = auth('web')->user()->id;
			$logged_guard = 'user';
		}elseif(auth('lawyer')->check()){
			$logged_id = auth('lawyer')->user()->id;
			$logged_guard = 'lawyer';
		}

		return datatables()->of($Messages)
			
			->addColumn('html', function ($row) use ($logged_id, $logged_guard) {


				$html = "";

				if($row->user_name){
					$overallrole='Render_law_firm_consultant';
					$name=$row->user_name;
					$userId= $row->user_id;
					$profile = "user_profile_image/" . $row->user_img;
				}

				if($row->lawyer_name){
					$overallrole='lawyer';
					$name=$row->lawyer_name;
					$userId= $row->lawyer_id;
					$profile = "lawyer/images/" . $row->lawyer_img;
				}

				if($row->customer_name){
					$overallrole='cutomer';
					$name=$row->customer_name;
					$userId= $row->customer_id;
					$profile = "customer_image/" . $row->customer_img;
				}

				
				$class = ($logged_id == $row->sent_messenger_id && $logged_guard == $row->guard) ? '' : 'chat-left';
				$attchmentClass = ($logged_id == $userId) ? 'badge text-light bg-white' : 'badge text-white bg-primary';
				return view('case_message.message', compact('overallrole', 'row', 'name', 'userId', 'logged_id', 'attchmentClass', 'class'))->render();
			})

			->addColumn('time', function ($row) {
				return $row->time;
			})
			->rawColumns(['html', 'time'])
			->make(true);
	}



	public function store(Request $request)
	{

		if (isset($request->document)) {

			$arr = ['message' => 'required', 'document' => 'mimes:jpeg,bmp,png,doc,pdf'];
		} else {
			$arr = ['message' => 'required'];
		}

		$validator = Validator::make($request->all(), $arr);
		if ($validator->fails()) {
			return response()->json([
				'sucess' => false,
				'errormessage' => $validator->errors(),


			], 422);
		}




		$caseMessage = new CaseMessage;
		$caseMessage->cases_id = $request->id;
		$caseMessage->messenger_id = $request->auth_id;
		$caseMessage->message = $request->message;
		$caseMessage->guard = $request->gaurd;
	

		$caseMessage->save();


		if (auth('customer')->check()) {
			$logged_id = auth('customer')->user()->id;
			$logged_guard = 'customer';
		} elseif (auth('web')->check()) {
			$logged_id = auth('web')->user()->id;
			$logged_guard = 'user';
		}elseif(auth('lawyer')->check()){
			$logged_id = auth('lawyer')->user()->id;
			$logged_guard = 'lawyer';
		}





		if (isset($request->document)) {

			$fileName = "message_document." . time() . "." .$logged_id. "." ."." .$logged_guard. ".". $request->document->getClientOriginalExtension();
			$request->document->move(public_path('message_documents/'), $fileName);

			

			$attachment = new CaseMessageAttachMent;
			$attachment->message_id = $caseMessage->id;
			$attachment->attachment_file =  $fileName;
			$attachment->save();
		}

		broadcast(new SendMessage($caseMessage, $attachment??''));
		return back();
	}





}




