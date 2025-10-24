<?php

namespace App\Models;

use App\Traits\ReadableHumanDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    use HasFactory, ReadableHumanDate;

    protected $guarded = [];

    public function registrationFees(): HasOne 
    {
        return $this->hasOne(RegistrationFee::class)->withDefault([
            'student_id' => '',
            'payment_method' => '',
            'payment_date'=> '',
            'amount' => '',
            'paid_amount' => '',
            'transaction_id'
        ]);  
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class)->withDefault(['name' => '']);
    }

    public function school(): BelongsTo 
    {
        return $this->belongsTo(School::class)->withDefault(['name' => '']);
    }

    public function healthyHistory(): HasOne
    {
        return $this->hasOne(StudentHealthyHistory::class)->withDefault([
            'diagnosis'     => '', 
            'medication'    => '', 
            'student_id'    => '', 
            'notes'         => ''
        ]);
    }

    public function installments(): HasMany
    {
        return $this->hasMany(Installment::class);
    }


    public function payments() : HasManyThrough
    {
        return $this->hasManyThrough(InstallmentPayment::class, Installment::class, 'student_id', 'installment_id');
    }


    public static function generateStudentNumber(): int
    {
        $year   = now()->year;
        $number = (int) Student::whereYear('created_at', $year)->max('student_number');
        if($number) {
            return ++$number;
        }
        return (int)($year . str_pad(++$number, 5, '0', STR_PAD_LEFT));
    }

    public function totalPaid() {
        return $this->payments?->sum(function($payment) {
            return $payment?->paid_amount ?? 0;
        });
    }
}
