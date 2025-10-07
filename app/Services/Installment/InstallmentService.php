<?php 

namespace App\Services\Installment;

use App\Http\Requests\Student\UpdateStudentRequest;
use App\Models\{Student, Installment};
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class InstallmentService 
{

    function __construct(
        private Installment $installment,
        private Student $student
    ) {}

    public function create(string $id) 
    {
        try {
            $studentName  = $this->student->findOrFail($id)->select('full_name')->get()[0]->full_name;
            return view('installments.create-installment-form', compact('id', 'studentName'));
        } catch (ModelNotFoundException $e) {
            report($e);
            return abort(404)->with('error', __('app.not_found'));
        }
    }
    
    public function store(Request $request)
    {
        $this->installment->create($request->validated());
        return back()->with('message', __('app.create_successful', ['attribute' => __('app.installment')]));
    }


    public function update(Installment $installment, Request $request) 
    {
        try {
            $installment->update($request->validated());
            return redirect()->back()->with('message', __('app.update_successful', ['attribute' => __('app.the_installment')]));
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy(Installment $installment)
    {
        try {
            $student = $installment->student;
            $installment->delete();
            return to_route('students.installments', $student)
                    ->with('message', __('app.delete_successful', [
                        'attribute' => __('app.installment')
                    ]
                )
            );
        } catch (ModelNotFoundException $e) {
            report($e);
            return abort(404);
        } catch (\Throwable $th) {
            report($th);
            return to_route('students.index')->with('error', $th->getMessage());
        }
    }
}