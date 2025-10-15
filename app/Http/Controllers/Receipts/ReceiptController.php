<?php

namespace App\Http\Controllers\Receipts;

use App\Http\Controllers\Controller;
use App\Models\InstallmentPayment;
use Omaralalwi\Gpdf\Facade\Gpdf as GpdfFacade;

class ReceiptController extends Controller
{
    public function receipt(InstallmentPayment $payment)
    {
        $html = view('receipts.receipts', compact('payment'))->render();
        $pdfContent = GpdfFacade::generate($html);
        return response($pdfContent, 200, ['Content-Type' => 'application/pdf']);
    }
}
