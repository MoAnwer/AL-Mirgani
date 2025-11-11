<?php

namespace App\Services\Student;

use App\Models\{Father, Student, ClassRoom, School};
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

    public function createStudentPage()
    {
        return view('students.register-new-student', [
            'title'   => trans('app.register_new_student'),
            'stages'  => StageEnum::cases(),
            'classes' => ClassRoom::pluck('id', 'name'),
            'schools' => School::pluck('id', 'name'),
        ]);
    }
 
    public function registerStudent(Request $request) 
    {
        $registrationData = $request->validated();

        DB::transaction(function() use ($registrationData) {
            $this->createRegistrationFeeFor(
                $this->createStudent($this->createParent($registrationData), $registrationData), $registrationData
            );
        });

        return back()->with('message', __('app.student_register_successfully'));
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
            'amount'  => $registrationFeeData['registration_fee'],
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
                                    $q->count();
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

    public function studentsCount(): array
    {
        return [
            'countBySchool' => $this->student
                                    ->select('school_id', 'schools.name as name', DB::raw('COUNT(students.id) AS count'))
                                    ->rightJoin('schools', 'schools.id', 'students.school_id')
                                    ->groupBy('school_id', 'name')
                                    ->get(),

            'countByClass' => $this->student
                                    ->select('class_id', 'classes.name as name', DB::raw('COUNT(students.id) AS count'))
                                    ->join('classes', 'classes.id', 'students.class_id')
                                    ->groupBy('class_id', 'name')
                                    ->get(),
        ];
    }
}