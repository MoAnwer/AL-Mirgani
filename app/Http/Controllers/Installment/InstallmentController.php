<?php

namespace App\Http\Controllers\Installment;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\Installment\InstallmentService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\Installment\StoreInstallmentRequest;
use Illuminate\Http\Request;

class InstallmentController extends Controller
{
    public function __construct(private InstallmentService $service) {}


    /**
     * @param string $id this is refer to student id
     */
    public function create(string $id)
    {
        try {

            $studentName  = Student::findOrFail($id)->select('full_name')->get()[0]->full_name;
            return view('installments.create-installment-form', compact('id', 'studentName'));
            
        } catch (ModelNotFoundException $th) {
            report($th);
            return redirect()->back()->with('error', __('app.not_found'));
        }
    }


    public function store(StoreInstallmentRequest $request)
    {
        return $this->service->store($request);
    }
}
