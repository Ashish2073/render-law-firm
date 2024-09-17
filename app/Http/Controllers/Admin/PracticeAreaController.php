<?php

namespace App\Http\Controllers\Admin;

use Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PracticeAreaRepository;

class PracticeAreaController extends Controller
{
    public function __construct(protected PracticeAreaRepository $practiceAreaRepository)
    {
    }

    public function index()
    {
        $model = $this->practiceAreaRepository;

        if(request()->has('name')){
            $model = $model->where('name', 'like', '%'.request('name').'%');
        }

        if(request()->has('status')){
            $model = $model->where('status', request('status'));
        }

        if(request()->has('parent')){
            $model = $model->where('parent_id', request('parent'));
        }

        if(request()->has('sort')){
            $model = $model->orderBy(request('sort'), request('order'));
        } else {
            $model = $model->orderBy('created_at', 'desc');
        }

        $practiceAreas = $model->paginate(20)->appends(request()->query());
        
        $breadcrumbs = [
            ['url' => route('admin.practice-areas') , 'name' => "Practice Areas"], 
        ];

        $parentPracticeAreas = $this->practiceAreaRepository->getParentPracticeAreas();
        
        return view('practice-areas.index', compact('practiceAreas', 'parentPracticeAreas', 'breadcrumbs'));
    }

    public function create()
    {
        $breadcrumbs = [
            ['url' => route('admin.practice-areas') , 'name' => "Practice Areas"],
            ['url' => route('admin.practice-areas.create'), 'name' => 'Practice area create']
        ];

        return view('practice-areas.create', compact('breadcrumbs'));
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'name' => 'required|min:3|max:25|unique:practice_areas',
            'description' => 'nullable',
            'status' => 'nullable',
            'parent_id' => 'nullable'
        ]);

        $data['slug'] = Str::slug($data['name']);

        $this->practiceAreaRepository->create($data);

        return redirect()->route('admin.practice-areas')->with('success', 'Practice area created successfully');
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function search()
    {
        $name = request('name');

        $practiceAreas = $this->practiceAreaRepository->where('name', 'like', '%'.$name.'%')->get();
        
        return response()->json([
            'success' => true,
            'practiceAreas' => $practiceAreas
        ]);
    }
}
