<?php

namespace App\Http\Controllers\App\Auth;

use App\Http\Controllers\Controller;


class AuthenticateUserController extends Controller
{

    public function show()
    {
        return auth()->user()->load('roles:id,name', 'profile:id,user_id,gender,date_of_birth,address,contact', 'profilePicture', 'status:id,name,class', 'socialLinks');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function registerView()
    {
        return view('frontend.user.invitation_confirm');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resetPasswordView()
    {
        return view('frontend.user.reset_password');
    }
}
