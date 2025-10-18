<?php

namespace App\Http\Controllers\Payments;

use App\Events\Earning\InstallmentPaymentIsPaid;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PaymentRequest;
use App\Models\Installment;
use App\Models\InstallmentPayment;

class InstallmentPaymentsController extends Controller
{
    public function paymentsList(Installment $installment) 
    {
        return view('installments_payments.payments-list', compact('installment'));
    }

    public function create(Installment $installment) {
        return view('installments_payments.create-payment-form', compact('installment'));
    }

    public function store(PaymentRequest $request, Installment $installment) 
    {
        try {

            $data = $request->validated();

            // Verify the installment remaining less the sended paid amount
            if ($installment->remaining  < $data['paid_amount']) {
                return redirect()
                        ->back()
                        ->with('error', __('app.amount_less_then_message', ['amount' => $installment->remaining]));
            }

            $payment = $installment->payments()->create($data);

            // To register payment in earing table
            event(new InstallmentPaymentIsPaid($payment));

            return redirect()->back()->with('message', __('app.create_successful', ['attribute' => __('app.payment')]));

        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    

    public function edit(InstallmentPayment $payment)
    {
        return view('installments_payments.edit-payment-form', compact('payment'));
    }

    public function update(InstallmentPayment $payment, PaymentRequest $request) 
    {
        try {
            $payment->update($request->validated());
            return redirect()->back()->with('message', __('app.create_successful', ['attribute' => __('app.payment')]));
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with('error', $th->getMessage());
        }   
    }

    public function delete(InstallmentPayment $payment)
    {
        return view('installments_payments.delete-payment', compact('payment'));
    }

    public function destroy(InstallmentPayment $payment)
    {
        $installment = $payment->installment;

        try {
            $payment->delete();
            return to_route('installments.payments.list', $installment)->with('message', __('app.delete_successful', ['attribute' => __('app.payment')]));
        } catch (\Throwable $th) {
            throw $th;
            return to_route('installments.payments.list', $installment)->with('error', $th->getMessage());
        }
    }
}
