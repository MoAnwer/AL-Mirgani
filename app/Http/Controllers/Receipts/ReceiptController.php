<?php

namespace App\Http\Controllers\Receipts;

use App\Events\Earning\InstallmentPaymentIsPaid;
use App\Http\Controllers\Controller;
use App\Models\{InstallmentPayment, Receipt};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceiptController extends Controller
{
    function __construct(private Receipt $receipt) {}


    public function index(Request $request)  
    {
        $query = $this->receipt->query();
        
        if ($search = strip_tags($request->query('search'))) {
            $query->where('number', 'like', "%{$search}%")
                  ->orWhereHas('student', function ($q) use ($search) {
                      $q->where('full_name', 'like', "%{$search}%"); 
                  });
        }

        $receipts = $query->with(['student', 'installmentPayment'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(15); 
        
        return view('receipts.receipts_list', compact('receipts'));
    }


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

                      // To register payment in earing table
                    event(new InstallmentPaymentIsPaid($payment));

                    return to_route('receipts.show', $receiptObject)->with('message', __('app.create_successful', __('app.receipt')));
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
