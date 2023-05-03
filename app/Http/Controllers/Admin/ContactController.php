<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('admin.contacts.index');
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
            'name_ar' => 'required',
            'name_en' => 'required',
            'message_ar' => 'required',
            'message_en' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'type' => 'required',
        ];

        $this->validate($request, $rules);
        $data['type'] = 1;

        Contact::query()->create($data);

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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Contact::query()->whereIn('id', explode(',', $id))->delete();
        return response()->json(['status' => true]);
    }

    public function indexTable(Request $request)
    {
        // dd('asd');
        // $contacts = Contact::query()->where('type', 1)->orderByDesc('created_at');
        // return DataTables::of($contacts)->addColumn('action', function ($contact) {
        //     $data = '';
        //     $data .= 'data-name_ar="' . $contact->name_ar . '"';
        //     $data .= 'data-name_en="' . $contact->name_en . '"';
        //     $data .= 'data-message_ar="' . $contact->message_ar . '"';
        //     $data .= 'data-message_en="' . $contact->message_en . '"';
        //     $data .= 'data-email="' . $contact->email . '"';
        //     $data .= 'data-mobile="' . $contact->mobile . '"';
        //     $data .= 'data-type="' . $contact->type . '"';
        //     $data .= 'data-id="' . $contact->id . '"';

        //     $string = '';
        //     $string .= '<button class="btn btn-warning edit_btn" ' . $data . '  data-bs-target="#editUser" data-bs-toggle="modal">Edit</button>';
        //     $string .= '<button class="btn btn-danger delete-btn" data-id=' . $contact->id . '>Delete</button>';

        //     return $string;
        // })->make(true);
    }
}
