<?php

namespace App\Enums;

enum PayrollItemsTypesEnum: string
{
    case ADDITION = 'Addition';
    case BENEFIT  = 'Benefit';
    case DEDUCTION = 'Deduction';
}
