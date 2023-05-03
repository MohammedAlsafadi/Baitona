<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('permissions', function (Request $request) {

    // DB::table('permissions')->truncate();
    // DB::table('roles')->truncate();
    // DB::table('model_has_roles')->truncate();
    // DB::table('role_has_permissions')->truncate();
    // DB::table('model_has_permissions')->truncate();

    $permission = Permission::insert([
        ['guard_name' => 'web', 'name' => 'show_users'],
        ['guard_name' => 'web', 'name' => 'create_users'],
        ['guard_name' => 'web', 'name' => 'edit_users'],
        ['guard_name' => 'web', 'name' => 'delete_users'],

        ['guard_name' => 'web', 'name' => 'show_articles'],
        ['guard_name' => 'web', 'name' => 'create_articles'],
        ['guard_name' => 'web', 'name' => 'edit_articles'],
        ['guard_name' => 'web', 'name' => 'delete_articles'],

        ['guard_name' => 'web', 'name' => 'show_partners'],
        ['guard_name' => 'web', 'name' => 'create_partners'],
        ['guard_name' => 'web', 'name' => 'edit_partners'],
        ['guard_name' => 'web', 'name' => 'delete_partners'],

        ['guard_name' => 'web', 'name' => 'show_sliders'],
        ['guard_name' => 'web', 'name' => 'create_sliders'],
        ['guard_name' => 'web', 'name' => 'edit_sliders'],
        ['guard_name' => 'web', 'name' => 'delete_sliders'],

        ['guard_name' => 'web', 'name' => 'show_videos'],
        ['guard_name' => 'web', 'name' => 'create_videos'],
        ['guard_name' => 'web', 'name' => 'edit_videos'],
        ['guard_name' => 'web', 'name' => 'delete_videos'],

        ['guard_name' => 'web', 'name' => 'show_reports'],
        ['guard_name' => 'web', 'name' => 'create_reports'],
        ['guard_name' => 'web', 'name' => 'edit_reports'],
        ['guard_name' => 'web', 'name' => 'delete_reports'],

        ['guard_name' => 'web', 'name' => 'show_programs'],
        ['guard_name' => 'web', 'name' => 'create_programs'],
        ['guard_name' => 'web', 'name' => 'edit_programs'],
        ['guard_name' => 'web', 'name' => 'delete_programs'],

        ['guard_name' => 'web', 'name' => 'show_sections'],
        ['guard_name' => 'web', 'name' => 'create_sections'],
        ['guard_name' => 'web', 'name' => 'edit_sections'],
        ['guard_name' => 'web', 'name' => 'delete_sections'],

        ['guard_name' => 'web', 'name' => 'show_roles'],
        ['guard_name' => 'web', 'name' => 'create_roles'],
        ['guard_name' => 'web', 'name' => 'edit_roles'],
        ['guard_name' => 'web', 'name' => 'delete_roles'],

        ['guard_name' => 'web', 'name' => 'show_contacts'],
    ]);


    // User::query()->first()->givePermissionTo([
    //     'show_users',
    //     'create_users',
    //     'edit_users',
    //     'delete_users',
    //     'show_articles',
    //     'create_articles',
    //     'edit_articles',
    //     'delete_articles',
    //     'show_partners',
    //     'create_partners',
    //     'edit_partners',
    //     'delete_partners',
    //     'show_sliders',
    //     'create_sliders',
    //     'edit_sliders',
    //     'delete_sliders',
    //     'show_videos',
    //     'create_videos',
    //     'edit_videos',
    //     'delete_videos',
    //     'show_reports',
    //     'create_reports',
    //     'edit_reports',
    //     'delete_reports',
    //     'show_programs',
    //     'create_programs',
    //     'edit_programs',
    //     'delete_programs',
    //     'show_sections',
    //     'create_sections',
    //     'edit_sections',
    //     'delete_sections',
    //     'show_roles',
    //     'create_roles',
    //     'edit_roles',
    //     'delete_roles',
    //     'show_contacts',
    // ]);


    return 'Done';
});
