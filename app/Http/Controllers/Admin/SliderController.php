<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SliderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('admin.sliders.index');
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
            'image' => 'required|file'
        ];

        $this->validate($request, $rules);

        $data = $request->except('image');

        if ($request->image) {
            $filename = rand(111111111, 999999999) . '_' . Carbon::now()->timestamp;
            $filename .= substr($request->image->getClientOriginalName(), strrpos($request->image->getClientOriginalName(), '.'));
            $filename = $request->image->move(public_path('images'), $filename);
            $data['image'] = $filename->getBasename();
        }

        Slider::query()->create($data);

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
        $slider = Slider::query()->find($id);

        $rules = [
            'title_ar' => 'required',
            'title_en' => 'required',
            'desc_ar' => 'required',
            'desc_en' => 'required',
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

        $slider->update($data);

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
        Slider::query()->whereIn('id', explode(',', $id))->delete();
        return response()->json(['status' => true]);
    }

    public function indexTable(Request $request)
    {
        // dd('asd');
        $sliders = Slider::query()->orderByDesc('created_at');
        return DataTables::of($sliders)->addColumn('action', function ($slider) {
            $data = '';
            $data .= 'data-title_ar="' . $slider->title_ar . '"';
            $data .= 'data-title_en="' . $slider->title_en . '"';
            $data .= 'data-desc_ar="' . $slider->desc_ar . '"';
            $data .= 'data-desc_en="' . $slider->desc_en . '"';
            $data .= 'data-image="' . $slider->image . '"';
            $data .= 'data-id="' . $slider->id . '"';

            $string = '';
            $string .= '<button class="btn btn-warning edit_btn" ' . $data . '  data-bs-target="#editUser" data-bs-toggle="modal">Edit</button>';
            $string .= '<button class="btn btn-danger delete-btn" data-id=' . $slider->id . '>Delete</button>';

            return $string;
        })->make(true);
    }
}
