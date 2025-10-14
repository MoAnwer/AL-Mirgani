<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureInstallmentIsPaid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->installment->total_payments >= $request->installment->amount) {
            return to_route('installments.payments.list', $request->installment->id)->with('message', __('app.installment_full_paid_message'));
        }
        return $next($request);
    }
}
