<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;


class RequiredIfBankak implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $paymentMethod = request()->input('payment_method');
        
        $isTransactionIdEmpty = is_null(request()->input('transaction_id'));

        if ($paymentMethod === 'بنكك') {            
            if ($isTransactionIdEmpty) {
                $fail(__('validation.transaction_number_required'));
                return;
            }
        } else { 
            if (!$isTransactionIdEmpty) {
                $fail(__('validation.transaction_number_related_with_bankak'));
                return;
            }
        }

       
    }
}