<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

use Illuminate\Support\Facades\Validator;

class SingleInputFieldController extends Controller
{
    protected $model;
    protected $viewPath;



    public function featureShow(Request $request)
    {

        if ($request->ajax()) {
            $items = $this->model::query()->orderBy('id', 'desc')->get();


            return datatables()->of($items)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<div class="d-flex gap-3"><button type="button" id="editUser' . $row->id . '" onclick="editFeature(' . $row->id . ')" class="edit btn btn-primary mr-2"><i class="far fa-edit"></i></button>';
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
                ->rawColumns(['action', 'status'])
                ->make(true);
        } else {
            return view($this->viewPath);
        }
    }

    public function featureSave(Request $request)
    {
        $modelInstance = new $this->model;
        $rules = ['name' => 'required|string|unique:' . $modelInstance->getTable() . ',name' . (isset($request->id) ? ',' . $request->id : '')];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errormessage' => $validator->errors(),
            ], 422);
        }

        $feature = $this->model::find($request->id) ?? new $this->model;
        $feature->name = $request->name;
        $feature->save();

        if (isset($request->id)) {
            return response()->json([
                'status' => true,
                'id' => $feature->id,
                'name' => $feature->name,
            ], 200);
        } else {
            return response()->json([
                'status' => true,
                'name' => $feature->name,
            ], 200);

        }
    }

    public function featureUpdate(Request $request)
    {
        $modelInstance = new $this->model;
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:' .  $modelInstance->getTable()  . ',name,' . $request->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errormessage' => $validator->errors(),
            ], 422);
        }

        $feature = $this->model::find($request->id);
        $feature->name = $request->name;
        $feature->save();

        return response()->json([
            'success' => true,
            'id' => $feature->id,
            'name' => $feature->name,
        ]);
    }

    public function featureStatusUpdate(Request $request)
    {
        $feature = $this->model::find($request->id);
        $feature->status = $request->status;
        $feature->save();

        return response()->json([
            'id' => $feature->id,
            'status' => $feature->status,
        ], 200);
    }



  

   
}
