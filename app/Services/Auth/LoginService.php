<?php

namespace App\Services\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginService
{
    public function authenticate(Request $request) : RedirectResponse
    {
        $credentials = $request->validated();

        if (Auth::attempt(
            ['username' => $credentials['username'], 'password' => $credentials['password']], 
            isset($credentials['remember_me'])
        )) 
        {
            $request->session()->regenerate();

            return redirect('dashboard');
        }

        return back()->withErrors([
            'username' => __('auth.fails')
        ]);
    }
}