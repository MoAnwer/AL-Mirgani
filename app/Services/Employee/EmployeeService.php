<?php

namespace App\Services\Employee;

use App\Enums\EmployeeTypes;
use App\Http\Requests\Employee\{StoreEmployeeRequest, UpdateEmployeeRequest};
use App\Models\{Employee, User};
use App\Notifications\{DeleteEmployeeNotification, CreateEmployeeNotification};
use Illuminate\Support\Facades\Notification;


final readonly class EmployeeService 
{
    function __construct(
        private Employee $employee
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Employee $employee)
    {
        return view('employees.employees-list', [
            'employees' => $employee->latest()->paginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employees.create-employee-form', [
            'title'         => __('app.create', ['attribute' => __('app.employee')]),
            'departments'   => EmployeeTypes::cases(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        try {

            $employee = $this->employee->create($request->validated());

            User::chunk(100, fn($user) => Notification::send($user, new CreateEmployeeNotification($employee)));
            
            return back()->with('message', __('app.create_successful', ['attribute' => __('app.employee')]));
        } catch (\Throwable $th) {
            report($th);
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return view('employees.employee-profile', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $departments = EmployeeTypes::cases();

        return view('employees.edit-employee-form', compact('employee', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        try {
            
            $employee->update($request->validated());
            
            return back()->with('message', __('app.update_successful', ['attribute' => __('app.employee')]));

        } catch (\Throwable $th) {

            report($th);

            return back()->with('error', __('app.error'));
        }
    }

    /**
     * Show delete confirmation page
     */
    public function delete(Employee $employee) 
    {
        return view('employees.delete-employee', compact('employee'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        try {

            $employee->payrolls()->update(['employee_id' => null]);

            $employee->delete();

            User::chunk(100, fn($user) => Notification::send($user, new DeleteEmployeeNotification($employee)));

            return to_route('employees.index')->with('message', __('app.delete_successful', ['attribute' => __('app.employee')]));

        } catch (\Throwable $th) {

            report($th);

            return back()->with('error', __('app.error'));
        }
    }
}