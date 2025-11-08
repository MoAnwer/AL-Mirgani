<?php

namespace App\Services\Student;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentHealthyHistoryService 
{
    public function update(Request $request, Student $student)
    {
        $request->validated();

        $medication = explode(',', $request->string('medication'));
        
        $student->healthyHistory()->updateOrCreate([
            'medication'        => $medication,
            'diagnosis'         => $request->string('diagnosis'),
            'notes'             => $request->string('notes')
        ]);

        return back()->with('message', __('app.update_successful', ['attribute' => __('app.healthy_history')]));
    }
}