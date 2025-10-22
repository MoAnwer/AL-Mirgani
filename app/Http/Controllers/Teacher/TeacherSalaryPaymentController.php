<?php

namespace App\Http\Controllers\Teacher;

use App\Events\Expense\SalaryPaid;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\StoreSalaryPaidRequest;
use App\Models\Teacher;
use App\Models\TeacherSalaryPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherSalaryPaymentController extends Controller
{
    public function __construct(
        private TeacherSalaryPayment $teacherSalaryPayment
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Teacher $teacher)
    {
        return view('teachers.payments.create-salary-payment', compact('teacher'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSalaryPaidRequest $request)
    {
        try {
            
            DB::transaction(function() use ($request) {

                $teacherSalaryPayment = $this->teacherSalaryPayment->create($request->validated());

                event(new SalaryPaid($teacherSalaryPayment));
            });

            return back()->with('message', __('app.create_successful', ['attribute' => __('app.salary_payment')]));

        } catch (\Throwable $th) {
            
            report($th);
            return back()->with('error', __('app.error') . ' :' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TeacherSalaryPayment $teacherSalaryPayment)
    {
        return view('teachers.payments.teacher-payments-list', compact('teacherSalaryPayment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeacherSalaryPayment $teacherSalaryPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TeacherSalaryPayment $teacherSalaryPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeacherSalaryPayment $teacherSalaryPayment)
    {
        //
    }
}
