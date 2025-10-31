<?php

namespace App\Http\Controllers\Earning;

use App\Http\Controllers\Controller;
use App\Http\Requests\Earning\CreateEarningRequest;
use App\Models\{School, Earning};

class EarningController extends Controller
{

    public function __construct(
        private School $school,
        private Earning $earning,
    ) {}

    public function index()
    {
        $filters = [
            'school_id'   => request()->query('school_id'),
            'date'        => request()->query('date'),
        ];

        $earnings = $this->earning
                        ->query()
                        ->with('school:id,name')
                        ->when(!empty($filters['school_id']),
                            function($q) use ($filters) {
                                $q->where('school_id', $filters['school_id']);
                            }
                        )
                        ->when(!empty($filters['date']),
                            function($q) use ($filters) {
                                $q->whereDate('date', $filters['date']);
                            }
                        )
                        ->latest()
                        ->paginate(15);

        $schools    = $this->school->pluck('id', 'name');

        return view('earnings.earning-list', compact('earnings', 'schools'));
    }

    public function create()
    {
        return view('earnings.create-earning-form', ['schools' => $this->school->pluck('id', 'name')]);
    }
    
    
    public function store(CreateEarningRequest $request)
    {
        $this->earning->create($request->validated());
        return back()->with('message', __('app.create_successful', ['attribute' => __('app.earning')]));
    }
}
