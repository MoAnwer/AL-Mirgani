<?php

namespace App\Http\Controllers\Earning;

use App\Http\Controllers\Controller;
use App\Http\Requests\Earning\CreateEarningRequest;
use App\Services\Earning\EarningService;

class EarningController extends Controller
{

    public function __construct(private readonly EarningService $earningService) {}

    /**
     * Earnings list with search filters
     */
    public function index()
    {
        return $this->earningService->earningsList();
    }

    /**
     * Create new earning page
     */
    public function create()
    {
        return $this->earningService->create();
    }

    /** 
     * Store the new earning data in database
     * @param CrateEarningRequest
    */
    public function store(CreateEarningRequest $request)
    {
        return $this->earningService->store($request);
    }
}
