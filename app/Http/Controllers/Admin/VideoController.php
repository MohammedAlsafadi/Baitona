<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VideoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function index()
    {
        return view('admin.videos.index');
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
            'link' => '',
            'video' => 'file'
        ];

        $this->validate($request, $rules);

        $data = $request->except('video');

        if ($request->video) {
            $filename = rand(111111111, 999999999) . '_' . Carbon::now()->timestamp;
            $filename .= substr($request->video->getClientOriginalName(), strrpos($request->video->getClientOriginalName(), '.'));
            $filename = $request->video->move(public_path('videos'), $filename);
            $data['video'] = $filename->getBasename();
        }

        Video::query()->create($data);

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
        $video = Video::query()->find($id);

        $rules = [
            'title_ar' => 'required',
            'title_en' => 'required',
            'link' => 'required',
            'video' => 'file'
        ];

        $this->validate($request, $rules);

        $data = $request->except('video');

        if ($request->video) {
            $filename = rand(111111111, 999999999) . '_' . Carbon::now()->timestamp;
            $filename .= substr($request->video->getClientOriginalName(), strrpos($request->video->getClientOriginalName(), '.'));
            $filename = $request->video->move(public_path('videos'), $filename);
            $data['video'] = $filename->getBasename();
        }

        $video->update($data);

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
        Video::query()->whereIn('id', explode(',', $id))->delete();
        return response()->json(['status' => true]);
    }

    public function indexTable(Request $request)
    {
        // dd('asd');
        $videos = Video::query()->orderByDesc('created_at');
        return DataTables::of($videos)->addColumn('action', function ($video) {
            $data = '';
            $data .= 'data-title_ar="' . $video->title_ar . '"';
            $data .= 'data-title_en="' . $video->title_en . '"';
            $data .= 'data-link="' . $video->link . '"';
            $data .= 'data-video="' . $video->video . '"';
            $data .= 'data-id="' . $video->id . '"';

            $string = '';
            $string .= '<button class="btn btn-warning edit_btn" ' . $data . '  data-bs-target="#editUser" data-bs-toggle="modal">Edit</button>';
            $string .= '<button class="btn btn-danger delete-btn" data-id=' . $video->id . '>Delete</button>';

            return $string;
        })->make(true);
    }
}
