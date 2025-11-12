<?php

namespace App\Http\Controllers;

use App\Models\EmployeePayroll;
use App\Models\PayrollDetail;
use App\Models\PayrollItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PayrollDetailController extends Controller
{

    function __construct(
        private PayrollItem $payrollItem,
        private PayrollDetail $payrollDetail,
    ) {}


    /**
     * Show the form for creating a new payroll detail (line item).
     */
    public function create(EmployeePayroll $payroll)
    {
        $payroll->load('employee');

        $items = $this->payrollItem->orderBy('name')->get();

        return view('payroll.details.create-payroll-details', compact('payroll', 'items'));
    }



    public function edit(EmployeePayroll $payroll, PayrollDetail $detail)
    {
        if ($detail->payroll_id !== $payroll->id) {
            abort(404);
        }

        $detail->load('item'); 
        
        $items = $this->payrollItem->orderBy('name')->get();

        return view('payroll.details.edit-payroll-details', compact('payroll', 'detail', 'items'));
    }

    
    /**
     * Store a newly created payroll detail in storage and update the parent summary.
     */
    public function store(Request $request, EmployeePayroll $payroll)
    {
  
        $request->validate([
            'item_id' => [
                'required',
                'exists:payroll_items,id',
                // Ensure this item hasn't already been added to this specific payroll
                Rule::unique('payroll_details')->where(function ($query) use ($payroll) {
                    return $query->where('payroll_id', $payroll->id);
                }),
            ],
            'amount' => 'required|numeric|min:0.01',
            'notes' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $payroll) {
            
            $this->payrollDetail->create([
                'payroll_id' => $payroll->id,
                'item_id' => $request->item_id,
                'amount' => $request->amount,
                'notes' => $request->notes,
            ]);

            // Recalculate the parent payroll's summary fields
            $this->recalculatePayrollSummary($payroll);
        });

        return to_route('payroll.show', $payroll->id)->with('message', __('app.create_successful', ['attribute' => __('app.salary')]));
    }



    public function update(Request $request, EmployeePayroll $payroll, PayrollDetail $detail)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:255',
        ]);
        
        if ($detail->payroll_id !== $payroll->id) {
            abort(403);
        }

        DB::transaction(function () use ($request, $payroll, $detail) {
            
            $detail->update([
                'amount' => $request->amount,
                'notes' => $request->notes,
            ]);

            $this->recalculatePayrollSummary($payroll);
        });

        return to_route('payroll.show', $payroll->id)->with('message', __('app.update_successful', ['attribute' => __('app.detail')]));
    }
    
    /**
     * Helper function to recalculate and save the totals in the parent payroll record.
     */
    private function recalculatePayrollSummary(EmployeePayroll $payroll)
    {
        // Eager load details with their item types
        $payroll->load('details.item');

        $totalVariableAdditions = $payroll->details
            ->where('item.type', 'Addition')
            ->sum('amount');
            
        $totalDeductions = $payroll->details
            ->whereIn('item.type', ['Deduction', 'Tax']) // Sum both deductions and taxes
            ->sum('amount');

        // Calculate new net pay
        $grossSalary = $payroll->basic_salary_snapshot + $payroll->total_fixed_allowances + $totalVariableAdditions;
        $netSalary = $grossSalary - $totalDeductions;
        
        // Update the parent record
        $payroll->update([
            'total_variable_additions' => $totalVariableAdditions,
            'total_deductions' => $totalDeductions,
            'net_salary_paid' => $netSalary,
        ]);
    }
}