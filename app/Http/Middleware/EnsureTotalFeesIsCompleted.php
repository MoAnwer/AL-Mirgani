<?php

namespace App\Http\Middleware;

use App\Models\Student;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTotalFeesIsCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $student = Student::findOrFail($request->student)->load('installments.payments');

        // total fees already paid
        if ($student->installments?->map(fn($installment) => $installment->amount)?->sum() == $student->total_fee) {
            return back()->with('message', __('app.fees_full_paid_message'));
        }
        return $next($request);
    }
}
