<?php

namespace App\Http\Controllers\Employees;

use App\Models\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\{StoreEmployeeRequest, UpdateEmployeeRequest};
use App\Services\Employee\EmployeeService;

class EmployeeController extends Controller
{
    function __construct(private readonly EmployeeService $employeeService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Employee $employee)
    {
        return $this->employeeService->index($employee);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->employeeService->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        return $this->employeeService->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return $this->employeeService->show($employee);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return $this->employeeService->edit($employee);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        return $this->employeeService->update($request, $employee);
    }

    /**
     * Show delete confirmation page
     */
    public function delete(Employee $employee)
    {
        return $this->employeeService->delete($employee);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        return $this->employeeService->destroy($employee);
    }
}
