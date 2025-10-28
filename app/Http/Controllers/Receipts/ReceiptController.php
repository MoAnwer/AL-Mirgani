<?php

namespace App\Http\Controllers\Receipts;

use App\Http\Controllers\Controller;
use App\Models\InstallmentPayment;
use App\Models\Receipt;
use Illuminate\Support\Facades\DB;

class ReceiptController extends Controller
{
    function __construct(private Receipt $receipt) {}


    public function store(InstallmentPayment $payment)
    {       
        // Check if the selected payment have no receipt to make one to it.
        if($payment->receipt_number == null) {

            // Start create receipt process
            return DB::transaction(function () use ($payment) {
            
                $receiptNumber = 'RC-' . time(); 

                $remanentAmount = $payment->student->total_fee - $payment->student->totalPaid(); 
                
                $receiptObject = $this->receipt->create([
                    'number'                    => $receiptNumber,
                    'amount'                    => $payment->paid_amount,
                    'student_id'                => $payment->student->id,
                    'remanent'                  => $remanentAmount,
                    'installment_payment_id'    => $payment->id,
                ]);
                
                $payment->update(['receipt_number' => $receiptNumber]);

                return to_route('receipts.show', $receiptObject)->with('message', 'تم تسجيل الإيصال بنجاح.');
            });

        } else {

            return redirect()->back();
        }

    }

    public function show(Receipt $receipt)
    {
        $receipt->load('student', 'installmentPayment'); 

        return view('receipts.show-receipt', compact('receipt'));
    }
}
