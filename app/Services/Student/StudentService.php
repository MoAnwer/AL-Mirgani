<?php

namespace App\Services\Student;

use App\Models\{Father, Student};
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
                $this->createStudent($this->createParent($registrationData), $registrationData) 
                , $registrationData
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
            'student_number'    => uniqid(),
            'address'           => $studentData['address'] ?? null,
            'total_fee'         => $studentData['total_fee'],
            'stage'             => $studentData['stage'],
            'school_id'         => $studentData['school'],
            'class_id'          => $studentData['class'],
        ]);
    }

    private function createRegistrationFeeFor(Student $student, array $registrationFeeData) : void 
    {
        $student->registrationFees()->create([
            'amount'            => $registrationFeeData['amount'],
            'payment_method'    => $registrationFeeData['payment_method']  ?? null,
            'payment_date'      => $registrationFeeData['payment_date']  ?? null,
            'paid_amount'       => $registrationFeeData['paid_amount']  ?? null,
            'transaction_id'    => $registrationFeeData['transaction_id'] ?? null
        ]);
    }

    public function studentsList() 
    {
        $students = $this->student
                         ->select('id', 'student_number', 'full_name', 'address', 'stage', 'school_id', 'class_id')
                         ->with('class:id,name', 'school:id,name')
                         ->paginate(8);

        return view('students.students-list', [
            'students' => $students, 
            'title' => __('app.students_list')
        ]);
    }
}