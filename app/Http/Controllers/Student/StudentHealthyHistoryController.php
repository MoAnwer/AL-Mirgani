<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\Student\StudentHealthyHistoryService;
use App\Http\Requests\Student\StudentHealthyHistoryRequest;

class StudentHealthyHistoryController extends Controller
{
    public function __construct(
        private StudentHealthyHistoryService $service
    ) {}

    public function show(Student $student)
    {
        return view('students.student-healthy-profile', compact('student'));
    }

    public function update(StudentHealthyHistoryRequest $request, Student $student)
    {
        return $this->service->update($request, $student);
    }

}
