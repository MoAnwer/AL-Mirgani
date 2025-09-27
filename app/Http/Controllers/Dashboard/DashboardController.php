<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function home() 
    {
        return view('dashboard.dashboard', [
            'title' => __('app.dashboard_title')
        ]);
    }
}
