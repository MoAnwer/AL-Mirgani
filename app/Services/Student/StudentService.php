<?php

namespace App\Services\Student;

use Exception;
use App\Models\{Father, Student, ClassRoom, Earning, RegistrationFee, School, User};
use App\Enums\StageEnum;
use App\Events\Student\RegisterStudent;
use App\Http\Requests\Student\StoreRegistrationFeeRequest;
use App\Http\Requests\Student\UpdateStudentRequest;
use App\Notifications\EarningNotification;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class StudentService
{
    function __construct(
        private readonly Student $student
    ) {}

    public function createStudentPage()
    {
        return view('students.register-new-student', [
            'title'   => trans('app.register_new_student'),
            'stages'  => StageEnum::cases(),
            'classes' => ClassRoom::pluck('id', 'name'),
            'schools' => School::pluck('id', 'name'),
            'paymentMethods' => ['كاش' => __('app.cash'), 'بنكك'  => __('app.bankak')]
        ]);
    }

    public function registerStudent(Request $request)
    {
        $registrationData = $request->validated();

        DB::transaction(function () use ($registrationData) {
            $this->createRegistrationFeeFor(
                $this->createStudent(
                    $this->createParent($registrationData), $registrationData
                ),
                $registrationData
            );
        });

        return back()->with('message', __('app.student_register_successfully'));
    }

    private function createParent(array $parentData): Father
    {
        return Father::firstOrCreate([
            'phone_one' => $parentData['phone_one'],
        ], [
            'full_name'  => $parentData['parent_name'] ?? null,
            'phone_one'  => $parentData['phone_one'] ?? null,
            'phone_two'  => $parentData['phone_two'] ?? null,
        ]);
    }

    private function createStudent(Father $parent, array $studentData): Student
    {
        return $parent->students()->create([
            'full_name'         => $studentData['full_name'],
            'student_number'    => Student::generateStudentNumber(),
            'address'           => $studentData['address'] ?? null,
            'discount'          => $studentData['discount'] ?? null,
            'total_fee'         => $this->calcDiscount($studentData['discount'] ?? 0, $studentData['total_fee'] ?? 0),
            'stage'             => $studentData['stage'] ?? null,
            'school_id'         => $studentData['school'] ?? null,
            'class_id'          => $studentData['class'] ?? null,
        ]);
    }

    private function createRegistrationFeeFor(Student $student, array $registrationFeeData): void
    {
        $student->registrationFees()->create([
            'amount'            => $registrationFeeData['registration_fee'] ?? null,
            'payment_method'    => $registrationFeeData['payment_method']  ?? null,
            'payment_date'      => $registrationFeeData['payment_date']  ?? null,
            'paid_amount'       => $registrationFeeData['paid_amount']  ?? null,
            'transaction_id'    => $registrationFeeData['transaction_id'] ?? null
        ]);

        if (isset($registrationFeeData['paid_amount'])) {
            event(new RegisterStudent($student));
        }
    }

    public function studentsList()
    {
        $search = request()->query('search');

        $students = $this->student
            ->query()
            ->select('id', 'student_number', 'full_name', 'address', 'stage', 'school_id', 'class_id')
            ->with('class:id,name', 'school:id,name')
            ->when(
                !empty($search),
                function ($q) use ($search) {
                    $q->whereAny(['full_name', 'student_number', 'stage'],  'LIKE', "%$search%");
                    $q->count();
                }
            )
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

            $request->validated();

            $totalPaymentsPaid = $student->totalPaid();

            // To check the sended total_fee grater than total installments payments 
            if ($totalPaymentsPaid > $request->input('total_fee')) return back()->withErrors(['full_name' => __('app.amount_less_then_message', ['amount' => $totalPaymentsPaid])]);


            $student->father()->update([
                'phone_one'   => $request->input('phone_one'),
                'phone_two'   => $request->input('phone_two'),
                'full_name'   => $request->input('parent_full_name')
            ]);

            $student->update($request->except(['phone_one', 'phone_two', 'parent_full_name']));

            return back()->with('message', __('app.update_successful', [
                'attribute' => __('app.student')
            ]));

        } catch (Exception $e) {

            if ($e->getCode() == 23000) {
                return back()->withErrors([
                    'full_name' => __('app.pls_select', ['item' => __('app.x-school')])
                ]);
            }
            
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


    private function calcDiscount($discount, $totalFee): int
    {
        return $totalFee * (1 - ($discount / 100));
    }

    public function registrationFeeDetailPage(Student $student) 
    {
        return view('students.registration-fee', [
            'registrationFees' => $student->registrationFees,
            'student' => $student
        ]);
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
                ->rightJoin('classes', 'classes.id', 'students.class_id')
                ->orderByDesc('count')
                ->groupBy('class_id', 'name')
                ->get(),
        ];
    }

    /**
     * Show create registration fee page 
     *
     * @param Student $student
     * @return View
     **/
    public function createRegistrationFeesPage(Student $student)
    {
        return view('students.create-registration-fees', [
            'student' => $student,
            'paymentMethods' => ['كاش' => __('app.cash'), 'بنكك'  => __('app.bankak')]
        ]);
    }

    /**
     * Store student registration fees
     *
     * @param StoreRegistrationFeeRequest $request 
     * @param Student $student
     * @return View
     **/
    public function storeRegistrationFees(StoreRegistrationFeeRequest $request, Student $student) 
    {
        try {
            
            $data = $request->validated();

            DB::transaction(function() use ($request, $student, $data) {

                $registrationFee = RegistrationFee::create([
                    "student_id" => $student->id,
                    "amount" => $data['amount'],
                    "paid_amount" => $data['paid_amount'],
                    "payment_method" => $data['payment_method'],
                    "payment_date" => $data['payment_date'],
                    "transaction_id" => $data['transaction_id'],
                ]);

                $earning = Earning::create([
                    'amount'    => $registrationFee->paid_amount,
                    'payment_method' => $registrationFee->payment_method,
                    'school_id'      => $student->school->id ?? null,
                    'transaction_id' => $registrationFee->transaction_id,
                    'statement' => __('app.student_registration_fee'),
                    'date'      => $registrationFee?->payment_date
                ]);

                User::chunk(100, function($user) use($earning) {
                    Notification::send($user, new EarningNotification($earning));
                });

            });

            return back()->with('message', __('app.student_register_successfully'));

        } catch (\Throwable $th) {

            report($th);

            return to_route('students.registrationFees.create', $student)->with('error', $th->getMessage());
        }
    }


}
