<?php

namespace App\Services\Earning;

use App\Http\Requests\Earning\CreateEarningRequest;
use App\Models\{School, Earning, User};
use App\Notifications\EarningNotification;
use Illuminate\Support\Facades\Notification;

final readonly class EarningService
{
    public function __construct(
        private School $school,
        private Earning $earning,
    ) {}


    /**
     * Earnings list with search filters
     * 
     * @return View
     */
    public function earningsList()
    {
        $filters = [
            'school_id'   => request()->query('school_id'),
            'date'        => request()->query('date'),
            'payment_method' => request()->query('payment_method'),
            'transaction_id' => request()->query('transaction_id'),
        ];

        $earnings = $this->earning
            ->query()
            ->with('school:id,name')
            ->when($filters['school_id'], fn ($q) => $q->where('school_id', $filters['school_id']))
            ->when($filters['date'], fn($q) => $q->whereDate('date', $filters['date']))
            ->when($filters['payment_method'], fn ($q) => $q->where('payment_method', $filters['payment_method']))
            ->when($filters['transaction_id'], fn($q) => $q->where('transaction_id', $filters['transaction_id']))
            ->latest()
            ->paginate(15);

        $schools    = $this->school->pluck('id', 'name');

        $paymentMethods = ['كاش' => __('app.cash'), 'بنكك'  => __('app.bankak')];

        return view('earnings.earning-list', compact('earnings', 'schools', 'paymentMethods'));
    }


    /**
     * Create new earning page
     */
    public function create()
    {
        return view('earnings.create-earning-form', ['schools' => $this->school->pluck('id', 'name')]);
    }

    /** 
     * Store the new earning data in database
     * @param CrateEarningRequest
     */
    public function store(CreateEarningRequest $request)
    {
        $earning = $this->earning->create($request->validated());

        User::chunk(100, function($user) use ($earing) {
            Notification::send($user, new EarningNotification($earning));
        });

        return back()->with('message', __('app.create_successful', ['attribute' => __('app.earning')]));
    }
}
