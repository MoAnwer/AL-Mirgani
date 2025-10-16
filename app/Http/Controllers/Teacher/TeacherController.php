<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\TeacherRule;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\TeacherRequest;
use App\Models\School;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Teacher $teacher)
    {
        return view('teachers.teachers-list', [
            'teachers' => $teacher->latest()->paginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teachers.create-teacher-form', [
            'title'     => __('app.create', ['attribute' => __('app.teacher')]),
            'schools'   => School::pluck('id', 'name'),
            'rules'     => TeacherRule::cases(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeacherRequest $request)
    {
        try {
            Teacher::create($request->validated());
            return back()->with('message', __('app.create_successful', ['attribute' => __('app.teacher')]));
        } catch (\Throwable $th) {
            report($th);
            return back()->with('error', __('app.error') .' :'. $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        return view('teachers.teacher-profile', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        return view('teachers.edit-teacher-form', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        //
    }


    public function delete(Teacher $teacher)
    {
        return view('teachers.delete-teacher', compact('teacher'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        //
    }
}
