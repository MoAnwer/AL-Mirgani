<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleController extends Controller
{
    public function setLocale(Request $request)
    {
        if (in_array($request->input('lang'), ['ar', 'en'])) {
            session()->put('locale', $request->input('lang'));
            App::setLocale($request->input('lang'));
            return redirect()->back();
        }
    }
}
