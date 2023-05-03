<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.auth.index');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect()->intended('/admin/dashboard');
        }else{
            return redirect(route('admin.login'));
        }
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect(route('admin.login'));
    }

    public function create()
    {
        $user = User::create([
            'first_name' => 'essam',
            'last_name' => 'shahla',
            'gender' => 0,
            'status' => 0,
            'date' => '2992003',
            'mobile' => '0599857341',
            'email' => 'essam@gmail.com',
            'city' => 'gaza',
            'specialty' => 'coding',
            'password' => bcrypt('password'),
        ]);

        // You can also add additional fields as needed

        return $user;
    }
}
