<?php

return [
    'required'  => 'حقل :attribute مطلوب',
    'in'        => 'الرجاء اختيار :attribute من الخيارات الموجودة',
    'min' => ['numeric' => ' :attribute يجب ان تكون من :min احرف على الاقل'],
    'date'      => 'الرجاء ادخال تاريخ صالح',
    'unique' => ':attribute موجود بالفعل .',
    'transaction_number_required' => 'رقم العملية مطلوب عند اختيار بنكك كوسيلة دفع',
    'transaction_number_related_with_bankak'  => 'لا يمكن إدخال رقم العملية إلا مع طريقة الدفع "بنكك" فقط. يرجى حذف رقم العملية عند اختيار طرق دفع أخرى (مثل الكاش).'
];
