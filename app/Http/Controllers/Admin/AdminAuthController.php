<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminAuthController extends LoginController
{
    //

    protected $redirectTo = 'admin/dashboard';
    protected $guard = 'admin';

    public function showLoginForm()
    {
        if(\Auth::guard('admin')->check())
        {
            return view('admin.dashboard');    
        }
        return view('admin.auth.login');
    }
    
    public function logout(Request $request)
    {
        $this->guard('admin')->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect(route('adminLogin'));
    }
}
