<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminForgotPasswordController extends Controller
{
    //

    public function forgotPassword()
    {
        return view('admin.auth.forgot_password');
    }
}
