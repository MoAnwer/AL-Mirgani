<?php

namespace App\Http\Controllers\Student;

use App\Enums\StageEnum;
use App\Http\Requests\Student\{UpdateStudentRequest, RegisterStudentRequest};
use App\Models\{ClassRoom, School, Student};
use App\Services\Student\StudentService;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    public function __construct(private StudentService $service) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->service->studentsList();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return $this->service->createStudentPage();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterStudentRequest $request)
    {
        return $this->service->registerStudent($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return view('students.student-profile', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return $this->service->editStudentForm($student);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        return $this->service->updateStudent($request, $student);
    }

    public function delete(Student $student)
    {
        return view('students.delete-student', compact('student'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        return $this->service->destroyStudent($student);
    }

    public function installments(Student $student)
    {
        return $this->service->installmentsList($student);
    }
}
