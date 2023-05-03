<?php

namespace App\Http\Controllers\Admin;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
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
        $permissions = Permission::all();
        return view('admin.roles.index', compact('permissions'));
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
            'name' => 'required',
            'permission_ids' => 'required|array',
            'permission_ids.*' => 'required|exists:permissions,id',
        ];

        $this->validate($request, $rules);

        $data = $request->only('name');
        $data['guard_name'] = 'admin';
        $role = Role::query()->create($data);

        $role->permissions()->sync($request->permission_ids);

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
        $role = Role::query()->find($id);

        $rules = [
            'name' => 'required',
            'permission_ids' => 'required|array',
            'permission_ids.*' => 'required|exists:permissions,id',
        ];

        $this->validate($request, $rules);

        $data = $request->only('name');


        $role->update($data);
        $role->permissions()->sync($request->permission_ids);

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
        //
    }

    public function indexTable(Request $request)
    {
        $items = Role::query();
        return DataTables::of($items)
            ->addColumn('action', function ($item) {
                $data = '';
                $data .= 'data-name="' . $item->name . '"';
                $data .= 'data-id="' . $item->id . '"';

                $perm_ids = implode(',', $item->permissions()->pluck('id')->toArray()) . ",";
                $data .= 'data-permissions="' . $perm_ids . '"';

                $string = '';


                $string .= '<button class="btn btn-warning edit_btn" ' . $data . '  data-bs-target="#editUser" data-bs-toggle="modal">Edit</button>';
                $string .= '<button class="btn btn-danger delete-btn" data-id=' . $item->id . '>Delete</button>';

                return $string;
            })->make(true);
    }
}
