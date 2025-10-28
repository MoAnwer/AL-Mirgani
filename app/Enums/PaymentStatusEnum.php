<?php

namespace App\Enums;

enum PaymentStatusEnum: string
{
    case PAID = 'Paid';
    case PENDING = 'Pending';
    case FAILED = 'Failed';
}
