<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Services\Reports\AccountsReportService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __construct(
        private readonly AccountsReportService $service
    ) {}


    public function showDailyAccount(Request $request)
    {
        return $this->service->report($request);
    }
}
