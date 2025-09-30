<?php

namespace App\Http\Controllers\Earning;

use App\Http\Controllers\Controller;
use App\Http\Requests\Earning\CreateEarningRequest;
use App\Models\{School, Earning};

class EarningController extends Controller
{
    public function index()
    {
        return view('earnings.earning-list', [
            'earnings'      => Earning::with('school')->latest()->paginate(15)
        ]);
    }

    public function create()
    {
        return view('earnings.create-earning-form', [
            'schools'    => School::pluck('id', 'name')
        ]);
    }
    
    
    public function store(CreateEarningRequest $request)
    {
        Earning::create($request->validated());
        return back()->with('message', __('app.create_successful', ['attribute' => __('app.earning')]));
    }
}
