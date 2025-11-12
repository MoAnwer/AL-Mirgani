<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PayrollItem; 
use Illuminate\Validation\Rule;

class PayrollItemController extends Controller
{

    function  __construct(private PayrollItem $payrollItem){}


    public function index()
    {
        $items = $this->payrollItem->latest()->paginate(15);
        
        return view('payroll.items.payroll-items-list', compact('items'));
    }

    
    public function create()
    {
        $itemTypes = ['Addition', 'Deduction'];
        
        return view('payroll.items.create-payroll-item', compact('itemTypes'));
    }

    public function edit(PayrollItem $payrollItem)
    {
        $itemTypes = ['Addition', 'Deduction'];
        
        return view('payroll.items.edit-payroll-item', ['item' => $payrollItem, 'itemTypes' => $itemTypes]);
    }


    public function update(Request $request, PayrollItem $payrollItem)
    {
        $request->validate([
            'name' => [
                'required', 
                'string', 
                'max:255', 
                Rule::unique('payroll_items', 'name')->ignore($payrollItem->id),
            ],
            'type' => ['required', Rule::in(['Addition', 'Deduction'])],
            'is_fixed' => 'boolean',
            'default_value' => 'nullable|numeric|min:0',
        ]);
        
        $payrollItem->update([
            'name' => $request->name,
            'type' => $request->type,
            'is_fixed' => $request->has('is_fixed'), 
            'default_value' => $request->default_value,
        ]);

        return redirect()->route('payroll_items.index')
                         ->with('message', __('app.update_successful', ['attribute' => __('app.item') ]));

    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:payroll_items,name',
            'type' => ['required', Rule::in(['Addition', 'Deduction', 'Tax', 'Benefit'])],
            'is_fixed' => 'boolean',
            'default_value' => 'nullable|numeric|min:0',
        ]);

        $this->payrollItem->create([
            'name' => $request->name,
            'type' => $request->type,
            'is_fixed' => $request->has('is_fixed'), 
            'default_value' => $request->default_value,
        ]);

        return back()->with('message', __('app.create_successful', ['attribute' => __('app.item')]));
    }
}