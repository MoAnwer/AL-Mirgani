<?php

namespace App\Http\Controllers\Payrolls;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payroll\StorePayrollRequest;
use App\Models\EmployeePayroll;
use App\Services\Payroll\PayrollService;
use Illuminate\Http\Request;

class PayrollController extends Controller
{

    public function __construct(private readonly PayrollService $payrollService) {}


    /**
     * Show payrolls list
     * 
     * @return View
     */
    public function index(Request $request)
    {
        return $this->payrollService->payrollsList($request);
    }


    /**
     * Create new employee payroll page
     * 
     * @return View
     */
    public function create()
    {
        return $this->payrollService->createPage();
    }


    /**
     * Store payroll
     * 
     * @return View
     */
    public function store(StorePayrollRequest $request)
    {
        return $this->payrollService->store($request);
    }



    /**
     * Show page of employee payroll
     * 
     * @param EmployeePayroll $payroll
     * @return View
     */
    public function show(EmployeePayroll $payroll)
    {
        return $this->payrollService->show($payroll);
    }


    /**
     * Edit page of employee payroll
     * @param EmployeePayroll $payroll
     * 
     * @return View
     */
    public function edit(EmployeePayroll $payroll)
    {
        return $this->payrollService->editPage($payroll);
    }


    /**
     * Update employee payroll data
     * 
     * @param Request $request
     * @param EmployeePayroll $payroll
     * @return View
     */
    public function update(Request $request, EmployeePayroll $payroll)
    {
        return $this->payrollService->update($request, $payroll);
    }


    /**
     * Print Payroll invoice page
     * 
     * @param EmployeePayroll $payroll
     */
    public function payrollInvoice(EmployeePayroll $payroll)
    {
        return $this->payrollService->payrollInvoice($payroll);
    }


    /**
     * Delete Employee Payroll Page 
     * 
     * @param EmployeePayroll $payroll
     */
    public function delete(EmployeePayroll $payroll)
    {
        return $this->payrollService->delete($payroll);
    }


    /**
     * Destroy payroll
     * 
     * @param EmployeePayroll $payroll
     */
    public function destroy(EmployeePayroll $payroll)
    {
        return $this->payrollService->destroy($payroll);
    }
}
