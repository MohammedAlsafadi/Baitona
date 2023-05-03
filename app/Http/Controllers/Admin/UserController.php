<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //
    public function index()
    {
        $roles = Role::all();
        return view('admin.users.index', compact('roles'));
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
            'first_name' => 'required',
            'last_name' => 'required',
            'image' => 'required|file',
            'gender' => 'required',
            'status' => 'required',
            'date' => 'required',
            'mobile' => 'required|digits:10',
            'email' => 'required|email',
            'password' => 'required',
            'city' => 'required',
            'specialty' => 'required',
            'role_ids' => 'required|array',
            'role_ids.*' => 'required|exists:roles,id',
        ];

        $this->validate($request, $rules);

        $data = $request->except('role_ids', 'image', 'password');

        if ($request->image) {
            $filename = rand(111111111, 999999999) . '_' . Carbon::now()->timestamp;
            $filename .= substr($request->image->getClientOriginalName(), strrpos($request->image->getClientOriginalName(), '.'));
            $filename = $request->image->move(public_path('images'), $filename);
            $data['image'] = $filename->getBasename();
        }
        $data['password'] = Hash::make($request->password);

        $user = User::query()->create($data);
        $user->roles()->sync($request->role_ids);
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
        $user = User::query()->find($id);

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'image' => 'file',
            'gender' => 'required',
            'status' => 'required',
            'date' => 'required',
            'mobile' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'city' => 'required',
            'specialty' => 'required',
            'role_ids' => 'required|array',
            'role_ids.*' => 'required|exists:roles,id',
        ];

        $this->validate($request, $rules);

        $data = $request->except('image' , 'role_ids');

        if ($request->image) {
            $filename = rand(111111111, 999999999) . '_' . Carbon::now()->timestamp;
            $filename .= substr($request->image->getClientOriginalName(), strrpos($request->image->getClientOriginalName(), '.'));
            $filename = $request->image->move(public_path('images'), $filename);
            $data['image'] = $filename->getBasename();
        }

        $user->update($data);
        $user->roles()->sync($request->role_ids);


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
        User::query()->whereIn('id', explode(',', $id))->delete();
        return response()->json(['status' => true]);
    }


    public function indexTable(Request $request)
    {
        // dd('asd');
        $users = User::query()->orderByDesc('created_at');
        return DataTables::of($users)
            ->addColumn('status', function ($item) {
                if ($item->status == 1) {
                    return  '<span class="badge bg-success">' . __('common.active') . '</span>';
                } else {
                    return  '<span class="badge bg-danger">' . __('common.inactive') . '</span>';
                }
            })
            ->addColumn('action', function ($user) {
                $data = '';
                $data .= 'data-image="' . $user->image . '"';
                $data .= 'data-first_name="' . $user->first_name . '"';
                $data .= 'data-last_name="' . $user->last_name . '"';
                $data .= 'data-email="' . $user->email . '"';
                $data .= 'data-password="' . $user->password . '"';
                $data .= 'data-mobile="' . $user->mobile . '"';
                $data .= 'data-city="' . $user->city . '"';
                $data .= 'data-specialty="' . $user->specialty . '"';
                $data .= 'data-gender="' . $user->gender . '"';
                $data .= 'data-status="' . $user->status . '"';
                $data .= 'data-id="' . $user->id . '"';


                $role_ids = implode(',', $user->roles()->pluck('id')->toArray()) . ",";
                $data .= 'data-roles="' . $role_ids . '"';


                $string = '';
                $string .= '<button class="btn btn-warning edit_btn" ' . $data . '  data-bs-target="#editUser" data-bs-toggle="modal">Edit</button>';
                $string .= '<button class="btn btn-danger delete-btn" data-id=' . $user->id . '>Delete</button>';

                return $string;
            })->rawColumns(['status', 'action'])->make(true);
    }
}
