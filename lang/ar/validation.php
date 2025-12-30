<?php

return [
    'required'  => 'حقل :attribute مطلوب',
    'required_if' => 'حقل :attribute مطلوب عندما يكون حقل :other قيمته :value',
    'in'        => 'الرجاء اختيار :attribute من الخيارات الموجودة',
    'min' => ['numeric' => ' :attribute يجب ان تكون من :min احرف على الاقل'],
    'date'      => 'الرجاء ادخال تاريخ صالح',
    'unique' => ':attribute موجود بالفعل .',
    'transaction_number_required' => 'رقم العملية مطلوب عند اختيار بنكك كوسيلة دفع',
    'transaction_number_related_with_bankak'  => 'لا يمكن إدخال رقم العملية إلا مع طريقة الدفع "بنكك" فقط. يرجى حذف رقم العملية عند اختيار طرق دفع أخرى (مثل الكاش).',
    'max_digits' => 'حقل :attribute يجب ان لا يزيد عن اكثر من :max خانات',
    'max' => [
        'string' => 'حقل :attribute يجب ان لا يتجاوز طوله اكثر من :max حرف',
        'numeric' => 'حقل :attribute يجب ان لا يكون اكبر من :max.'
    ],
    'password' => [
        'numbers' => 'يجب ان تحتوي كلمة السر على ارقام',
        'symbols' => 'يجب ان تحتوي كلنة السر على رموز خاصة (مثل #@)',
    ],
];
