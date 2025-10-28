<?php

namespace App\Enums;

enum EmployeeTypes: string
{
    case TEACHER = "معلم";
    case WORKER = "عامل";
    case MANAGER = "إدراي";
}
