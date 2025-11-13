<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\SecurityQuestion;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct(private readonly SecurityQuestion $securityQuestion) {}


    public function settingsPage()
    {
        $securityQuestions = $this->securityQuestion->where('user_id', auth()->user()->id)->get();

        return view('settings.settings-page', compact('securityQuestions'));
    }
}
