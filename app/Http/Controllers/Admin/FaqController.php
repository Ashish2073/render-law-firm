<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\FaqWithCategory;
use App\Http\Controllers\Base\SingleInputFieldController;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\DB;

class FaqController extends SingleInputFieldController
{
    public function __construct()
    {
        $this->model = FaqCategory::class;
        $this->viewPath = 'faq.category.index';
    }


    public function faqQuestionShow(Request $request)
    {

        if ($request->ajax()) {

            $items = Faq::getFaqWithCategories()->orderBy('faqs.id', 'desc');


            return datatables()->of($items)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<div class="d-flex gap-3"><button type="button" id="editFaq' . $row->id . '" onclick="editFaq(' . $row->id . ')" class="edit btn btn-primary mr-2"><i class="far fa-edit"></i></button>';
                    $btn .= '<button type="button" onclick="workInProgress(' . $row->id . ')" 
                    class="delete btn btn-danger "><i class="fas fa-trash-alt"></i></button></div>';
                    return $btn;
                })
                ->addColumn('status', function ($row) {
                    $status_text = $row->status == 1 ? 'Active' : 'Inactive';
                    $status_btn = $row->status == 1 ? 'btn btn-success' : 'btn btn-danger';
                    $feature_status = "<button type='button' id='statuschange$row->id' onclick='changeStatus($row->id)' class='$status_btn'>$status_text</button>";
                    return $feature_status;
                })

                ->addColumn('question', function ($row) {

                    $question = $row->question;
                    return $question;
                })


                ->addColumn('answer', function ($row) {

                    $answer = $row->answer;
                    return $answer;
                })

                ->rawColumns(['question', 'answer', 'action', 'status'])

                ->make(true);

        } else {
            $faqCategory = FaqCategory::all();
            return view('faq.question.index', ['faqCategory' => $faqCategory]);
        }


    }


    public function textareaimageupload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '__' . time() . '.' . $extension;
            $request->file('upload')->move(public_path('textarea'), $fileName);
            $url = asset('textarea/' . $fileName);
            return response()->json([
                'fileName' => $fileName,
                'uploaded' => 1,
                'url' => $url,
            ]);

        }
    }


    public function faqSave(Request $request)
    {



        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'text_area_question' => 'required|max:1000',
            'text_area_answer' => 'required|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errormessage' => $validator->errors(),
            ], 422);
        }


        DB::beginTransaction();

        try {

            if (isset($request->id)) {

                $faq = Faq::find($request->id);
                $faq->question = $request->text_area_question;
                $faq->answer = $request->text_area_answer;
                $faq->save();

            } else {

                $faq = new Faq();
                $faq->question = $request->text_area_question;
                $faq->answer = $request->text_area_answer;
                $faq->save();
            }



            if ($faq) {

                if (isset($request->id)) {

                    $faqWithCategory = FaqWithCategory::where('faq_id', $request->id)->update([
                        'category_id' => $request->category
                    ]);

                } else {
                    $faqWithCategory = new FaqWithCategory();
                    $faqWithCategory->category_id = $request->category;
                    $faqWithCategory->faq_id = $faq->id;
                    $faqWithCategory->save();

                }

            }


            DB::commit();

            if (isset($request->id)) {
                $faq = Faq::getFaqWithCategories()->where('faqs.id', '=', $request->id)->get();

                return response()->json([
                    'update' => true,
                    'faq' => $faq,


                ], 200);


            } else {
                return response()->json([
                    'save' => true,
                ], 200);
            }


        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'errormessage' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function updateCategory(Request $request)
    {

        $faqWithCategory = FaqWithCategory::where('faq_id', $request->faq_id)->update([
            'category_id' => $request->category_id
        ]);
        $faq = Faq::getFaqWithCategories()
            ->where('faqs.id', '=', $request->faq_id)
            ->get();

        return response()->json([
            'update' => true,
            'faq' => $faq,


        ], 200);

    }


    public function faqStatusChange(Request $request)
    {

        $faq = Faq::find($request->id);
        $faq->status = $request->status;

        $faq->save();

        return response()->json([
            'id' => $faq->id,
            'status' => $faq->status,

        ], 200);
    }


    public function updateQuestion(Request $request){

        

        $faq = Faq::find($request->faq_id);
        $faq->question = $request->question;

        $faq->save();

        return response()->json([
            'id' => $faq->id,
            'question' => $faq->question,

        ], 200);

    }

    public function updateAnswer(Request $request){
        
        $faq = Faq::find($request->faq_id);
        $faq->answer = $request->answer;

        $faq->save();

        return response()->json([
            'id' => $faq->id,
            'answer' => $faq->answer,

        ], 200);

    }

}