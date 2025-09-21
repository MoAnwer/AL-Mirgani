<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\LoginService;

class LoginController extends Controller
{
    public function __construct(
        private LoginService $service
    ) {}


    public function login()
    {
        return view('auth.login', [
            'title' => __('auth.login_page')
        ]);
    }

    public function loginAction(LoginRequest $request) 
    {   
        return $this->service->authenticate($request);
    }
}
