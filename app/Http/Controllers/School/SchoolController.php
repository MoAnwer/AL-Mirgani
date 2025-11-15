<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use App\Notifications\CreateSchoolNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class SchoolController extends Controller
{

    public function __construct(private readonly School $school) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schools = $this->school->latest()->paginate(15);

        return view('schools.schools-list', compact('schools'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('schools.create-school');
    }


    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $data = $request->validate(['name' => 'required|string']);

            $school = $this->school->create($data);

            Notification::sendNow(User::all(), new CreateSchoolNotification($school));

            return to_route('schools.index')->with('message', __('app.create_successful', ['attribute' => __('app.school')]));

        } catch (\Throwable $th) {

            report($th);

            return back()->with('error', __('app.error'));
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(School $school)
    {
        return view('schools.edit-school', compact('school'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, School $school)
    {
        try {

            $data = $request->validate(['name' => 'required|string'], [], ['name' => __('app.name_of', ['name' => __('app.school')])]);

            $school->update($data);

            return to_route('schools.index')->with('message', __('app.update_successful', ['attribute' => __('app.school')]));

        } catch (\Throwable $th) {

            report($th);

            return back()->with('error', __('app.error') . ': ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school)
    {
        // TODO: delete school
    }
}
