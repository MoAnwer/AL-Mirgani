<?php

namespace App\Http\Controllers\Reports;

use App\Enums\ExpenseCategoryEnum;
use App\Http\Controllers\Controller;
use App\Models\{Earning, Expense, School};
use App\Services\Reports\IncomeReportService;

class EarningStatementReportController extends Controller
{

    function __construct(private readonly IncomeReportService $service) {}

    public function generateIncomeStatement()
    { 
        return $this->service->report();
    }
}