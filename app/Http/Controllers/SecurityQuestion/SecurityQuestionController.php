<?php

namespace App\Http\Controllers\SecurityQuestion;

use App\Http\Controllers\Controller;
use App\Models\SecurityQuestion;
use Illuminate\Http\Request;

class SecurityQuestionController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('settings.create-security-question');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SecurityQuestion $securityQuestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SecurityQuestion $securityQuestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SecurityQuestion $securityQuestion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SecurityQuestion $securityQuestion)
    {
        //
    }
}
