<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('admin.reports.index');
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
            'type' => 'required',
            'year' => 'required',
            'file' => 'required',
        ];

        $this->validate($request, $rules);

        $data = $request->except('file');

        if ($request->image) {
            $filename = rand(111111111, 999999999) . '_' . Carbon::now()->timestamp;
            $filename .= substr($request->file->getClientOriginalName(), strrpos($request->file->getClientOriginalName(), '.'));
            $filename = $request->image->move(public_path('files'), $filename);
            $data['file'] = $filename->getBasename();
        }

        Report::query()->create($data);

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
        $report = Report::query()->find($id);

        $rules = [
            'type' => 'required',
            'year' => 'required',
            'file' => 'nullable',
        ];

        $this->validate($request, $rules);
        $data = $request->except('file');

        if ($request->file) {
            $filename = rand(111111111, 999999999) . '_' . Carbon::now()->timestamp;
            $filename .= substr($request->file->getClientOriginalName(), strrpos($request->file->getClientOriginalName(), '.'));
            $filename = $request->file->move(public_path('files'), $filename);
            $data['file'] = $filename->getBasename();
        }

        $report->update($data);

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
        Report::query()->whereIn('id', explode(',', $id))->delete();
        return response()->json(['status' => true]);
    }

    public function indexTable(Request $request)
    {
        // dd('asd');
        $reports = Report::query()->orderByDesc('created_at');
        return DataTables::of($reports)->addColumn('action', function ($report) {
            $data = '';
            $data .= 'data-type="' . $report->type . '"';
            $data .= 'data-year="' . $report->year . '"';
            $data .= 'data-file="' . $report->file . '"';
            $data .= 'data-id="' . $report->id . '"';

            $string = '';
            // $string .= '<a href="'.route('reports.download',$report->id).'" class="btn btn-info" data-id=' . $report->id . '>Download</a>';
            $string .= '<button class="btn btn-warning edit_btn" ' . $data . '  data-bs-target="#editUser" data-bs-toggle="modal">Edit</button>';
            $string .= '<button class="btn btn-danger delete-btn" data-id=' . $report->id . '>Delete</button>';

            return $string;
        })->make(true);
    }

    // public function getDownload($id)
    // {
    //     $report = Report::query()->find($id);
    //     $file = public_path('/files/' . $report->file);
        
    //     return Response::download($file);
    // }
}
