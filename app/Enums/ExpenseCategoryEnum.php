<?php

namespace App\Enums;

enum ExpenseCategoryEnum : string
{
    case SALARIES = "مرتبات";
    case RENTS = "ايجارات";
    case ELECTRICITY_AND_WATER = 'كهرباء و مياه';
    case UPKEEP = 'صيانة';
    case BOOKS = 'كتب';
    case INCENTIVES = 'حوافز مالية';
    case SCHOOLS = 'تصديقات مدارس';
    case UNIFORM = 'زي مدرسي';
    case MANAGEMENT = 'رسوم ادارية';
    case OTHER = 'اخرى';
    case TOOLS = 'ادوات مكتبية';
    case PRINT_EXAMS = 'طباعة امتحانات';
    case TRAVEL = 'ترحيل';
    case BUFFET=  'بوفية';
    case FURNITURE = 'اثاث';
    case HELPS = "معينات";
    case INTER_BRANCH = 'جاري الفروع';
}