<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Section;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class SectionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programs = Program::query()->get();
        return view('admin.sections.index', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title_ar' => 'required',
            'title_en' => 'required',
            'desc_ar' => 'required',
            'desc_en' => 'required',
            'program_id' => 'required',
            'image' => 'required|file'
        ];

        $this->validate($request, $rules);

        $data = $request->only('title_ar', 'title_en', 'desc_ar', 'desc_en', 'program_id');

        if ($request->image) {
            $filename = rand(111111111, 999999999) . '_' . Carbon::now()->timestamp;
            $filename .= substr($request->image->getClientOriginalName(), strrpos($request->image->getClientOriginalName(), '.'));
            $filename = $request->image->move(public_path('images'), $filename);
            $data['image'] = $filename->getBasename();
        }

        Section::query()->create($data);

        return response()->json(['status' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $section = Section::query()->find($id);

        $rules = [
            'title_ar' => 'required',
            'title_en' => 'required',
            'desc_ar' => 'required',
            'desc_en' => 'required',
            'program_id' => 'required',
            'image' => 'file'
        ];

        $this->validate($request, $rules);

        $data = $request->except('image');

        if ($request->image) {
            $filename = rand(111111111, 999999999) . '_' . Carbon::now()->timestamp;
            $filename .= substr($request->image->getClientOriginalName(), strrpos($request->image->getClientOriginalName(), '.'));
            $filename = $request->image->move(public_path('images'), $filename);
            $data['image'] = $filename->getBasename();
        }

        $section->update($data);

        return response()->json(['status' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Section::query()->whereIn('id', explode(',', $id))->delete();
        return response()->json(['status' => true]);
    }


    public function indexTable(Request $request)
    {
        $sections = Section::query()->orderByDesc('created_at');
        return DataTables::of($sections)->addColumn('action', function ($item) {
            $data = '';
            $data .= 'data-title_ar="' . $item->title_ar . '"';
            $data .= 'data-title_en="' . $item->title_en . '"';
            $data .= 'data-desc_ar="' . $item->desc_ar . '"';
            $data .= 'data-desc_en="' . $item->desc_en . '"';
            $data .= 'data-image="' . $item->image . '"';
            $data .= 'data-program_id="' . $item->program_id . '"';
            $data .= 'data-id="' . $item->id . '"';

            $string = '';
            $string .= '<button class="btn btn-warning edit_btn" ' . $data . '  data-bs-target="#editUser" data-bs-toggle="modal">Edit</button>';
            $string .= '<button class="btn btn-danger delete-btn" data-id=' . $item->id . '>Delete</button>';

            return $string;
        })->make(true);
    }
}
