<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PaymentRequest;
use App\Models\Installment;
use App\Models\InstallmentPayment;
use App\Rules\RequiredIfBankak;
use App\Rules\UniqueInTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstallmentPaymentsController extends Controller
{
    public function paymentsList(Installment $installment)
    {
        return view('installments_payments.payments-list', compact('installment'));
    }

    public function create(Installment $installment)
    {
        $paymentMethods = ['كاش' => __('app.cash'), 'بنكك'  => __('app.bankak')];

        return view('installments_payments.create-payment-form', compact('installment', 'paymentMethods'));
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

            DB::transaction(function () use ($installment, $data) {
                $payment = $installment->payments()->create($data);
            });

            return redirect()->back()->with('message', __('app.create_successful', ['attribute' => __('app.payment')]));
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    public function edit(InstallmentPayment $payment)
    {
        if ($payment->receipt_number != null) {
            return to_route('installments.payments.list', $payment->installment->id);
        }

        $paymentMethods = ['كاش' => __('app.cash'), 'بنكك'  => __('app.bankak')];

        $payment->loadMissing(['installment:id,number,student_id', 'installment.student:id,full_name']);

        return view('installments_payments.edit-payment-form', compact('payment', 'paymentMethods'));
    }

    public function update(InstallmentPayment $payment, Request $request)
    {
        try {

            $data = $request->validate([
                'paid_amount'       => 'required',
                'payment_method'    => 'nullable',
                'payment_date'      => 'required|date',
                'statement'         => 'required',
                'student_id'        => 'required',
                'transaction_id'    =>  [
                    'sometimes',
                    $request->transaction_id != null ? new RequiredIfBankak() : '',
                    $request->transaction_id == null && $payment->transaction_id == null && $request->payment_method == 'بنكك' ? new RequiredIfBankak() : '',
                    $request->transaction_id != $payment->transaction_id ? 
                    new UniqueInTables(
                        tables: ['earnings', 'expenses', 'registration_fees', 'installment_payments', 'employee_payrolls'],
                        column: 'transaction_id',
                    ) : '',
                ],
            ]);

              // Check if transaction_id is null and payment_date is bankak
            if ($data['transaction_id'] == null && $data['payment_method'] == 'بنكك') {
                // make the send transaction id == old payroll transaction id
                $data['transaction_id'] = $payment->transaction_id;
            }

            // Check if transaction_id is null and payment_date is not bankak
            if ($data['transaction_id'] == null && $data['payment_method'] != 'بنكك') {
                // make the send transaction id equal null
                $data['transaction_id'] = null;
            }
            
            $payment->update($data);
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
