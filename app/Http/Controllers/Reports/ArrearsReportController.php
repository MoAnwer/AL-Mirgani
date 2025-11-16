<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Services\Reports\ArrearsReportService;

class ArrearsReportController extends Controller
{
    function __construct(private readonly ArrearsReportService $service) {}

    public function generateArrearsReport()
    {
        return $this->service->report();
    }
}
