<?php

namespace App\Services\Student;

use App\Models\Father;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentService 
{
    public function registerStudent(Request $request) 
    {
        $registrationData = $request->validated();

        DB::transaction(function() use ($registrationData) {

            $parent = Father::firstOrCreate([
                'phone_one' => $registrationData['phone_one'],
            ], [
                'full_name'  =>  $registrationData['parent_name'],
                'phone_one'  => $registrationData['phone_one'],
                'phone_two'  => $registrationData['phone_two'] ?? null,
            ]);

            $student = $parent->students()->create([
                'full_name'     => $registrationData['full_name'],
                'student_number' => uniqid(),
                'address'       => $registrationData['address'] ?? null,
                'total_fee'     => $registrationData['total_fee'] ?? null,
                'stage'         => $registrationData['stage'],
                'school_id'        => $registrationData['school'] ?? null,
                'class_id'        => $registrationData['class'] ?? null,
            ]);

            $student->registrationFees()->create([
                'amount' => $registrationData['amount']  ?? null,
                'payment_method' => $registrationData['payment_method']  ?? null,
                'payment_date' => $registrationData['payment_date']  ?? null,
                'paid_amount' => $registrationData['paid_amount']  ?? null,
                'transaction_id' => $registrationData['transaction_id'] ?? null
            ]);
        });

        return redirect('/dashboard');
    }
}