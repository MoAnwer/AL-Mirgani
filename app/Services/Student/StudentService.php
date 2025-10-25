<?php

namespace App\Services\Student;

use App\Models\{Father, Student, ClassRoom, Installment, School};
use App\Enums\StageEnum;
use App\Events\Student\RegisterStudent;
use App\Http\Requests\Student\UpdateStudentRequest;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentService 
{
    function __construct(
        private Student $student
    ) {}

    public function registerStudent(Request $request) 
    {
        $registrationData = $request->validated();

        DB::transaction(function() use ($registrationData) {
            $this->createRegistrationFeeFor(
                $this->createStudent($this->createParent($registrationData), $registrationData), $registrationData
            );
        });

        return back()->with('message', 'تم تسجيل الطالب بنجاح ✅');
    }

    private function createParent(array $parentData) : Father
    {
        return Father::firstOrCreate([
                'phone_one' => $parentData['phone_one'],
            ], [
                'full_name'  => $parentData['parent_name'],
                'phone_one'  => $parentData['phone_one'],
                'phone_two'  => $parentData['phone_two'] ?? null,
            ]);
    }

    private function createStudent(Father $parent, array $studentData) : Student 
    {
        return $parent->students()->create([
            'full_name'         => $studentData['full_name'],
            'student_number'    => Student::generateStudentNumber(),
            'address'           => $studentData['address'] ?? null,
            'discount'          => $studentData['discount'] ?? null,
            'total_fee'         => $this->calcDiscount($studentData['discount'] ?? 0, $studentData['total_fee']),
            'stage'             => $studentData['stage'],
            'school_id'         => $studentData['school'],
            'class_id'          => $studentData['class'],
        ]);
    }

    private function createRegistrationFeeFor(Student $student, array $registrationFeeData) : void 
    {
        $student->registrationFees()->create([
            'registration_fee'  => $registrationFeeData['registration_fee'],
            'payment_method'    => $registrationFeeData['payment_method']  ?? null,
            'payment_date'      => $registrationFeeData['payment_date']  ?? null,
            'paid_amount'       => $registrationFeeData['paid_amount']  ?? null,
            'transaction_id'    => $registrationFeeData['transaction_id'] ?? null
        ]);

        event(new RegisterStudent($student));
    }

    public function studentsList() 
    {
        $search = request()->query('search');
        
        $students = $this->student
                            ->query()
                            ->select('id', 'student_number', 'full_name', 'address', 'stage', 'school_id', 'class_id')
                            ->with('class', 'school')
                            ->when(!empty($search), 
                                function($q) use ($search) {
                                    $q->whereAny(['full_name', 'student_number', 'stage'],  'LIKE', "%$search%");
                            })
                            ->latest()
                            ->paginate(10);

        return view('students.students-list', compact('students'));
    }


    public function editStudentForm(Student $student) 
    {
        try {   
            return view('students.edit-student', [
                'student' => $student,
                'stages'  => StageEnum::cases(),
                'classes' => ClassRoom::pluck('id', 'name'),
                'schools' => School::pluck('id', 'name')
            ]);
        } catch (ModelNotFoundException $e) {
            report($e);
            return to_route('students.index')->with('error', __('app.student_not_found'));
        }
    }


    public function updateStudent(UpdateStudentRequest $request, Student $student) 
    {
        try {

            $student->update($request->validated());

            return back()->with('message', __('app.update_successful', [
                'attribute' => __('app.student')
            ]));

        } catch (Exception $e) {
            return back()->withErrors([
                'full_name' => $e->getMessage()
            ]);
        }
    }

    public function destroyStudent(Student $student) 
    {
        try {
            $student->delete();
            return to_route('students.index')->with('message', __('app.delete_successful', ['attribute' => __('app.student')]));
        } catch (ModelNotFoundException $e) {
            report($e);
            return to_route('students.index')->with('error', __('app.student_not_found'));
        }
    }

    public function installmentsList(Student $student)
    {
        return view('students.student-installments-list', [
            'student' => $student,
            'installments' => $student->installments()->latest()->get(),
        ]);
    }


    private function calcDiscount($discount, $totalFee) : int
    {
        return $totalFee * (1 - ($discount / 100));
    }
}