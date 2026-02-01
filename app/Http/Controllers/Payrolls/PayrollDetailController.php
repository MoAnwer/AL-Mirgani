<?php

namespace App\Http\Controllers\Payrolls;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payroll\StorePayrollDetail;
use App\Models\{PayrollDetail, EmployeePayroll};
use App\Services\Payroll\PayrollDetailService;
use Illuminate\Http\Request;

class PayrollDetailController extends Controller
{

    public function __construct(
        private readonly PayrollDetailService $service
    ) {}


    /**
     * Show the form for creating a new payroll detail (line item).
     */
    public function create(EmployeePayroll $payroll)
    {
        return $this->service->create($payroll);
    }

    public function edit(EmployeePayroll $payroll, PayrollDetail $detail)
    {
        return $this->service->edit($payroll, $detail);
    }

    /**
     * Store a newly created payroll detail in storage and update the parent summary.
     */
    public function store(StorePayrollDetail $request, EmployeePayroll $payroll)
    {
        return $this->service->store($request, $payroll);
    }

    public function update(Request $request, EmployeePayroll $payroll, PayrollDetail $detail)
    {
        return $this->service->update($request, $payroll, $detail);
    }

    public function delete(PayrollDetail $detail) 
    {
        return $this->service->delete($detail);
    }

    public function destroy(PayrollDetail $detail) 
    {
        return $this->service->destroy($detail);
    }
}
