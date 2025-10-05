<?php 

namespace App\Services\Installment;

use App\Models\Installment;
use Illuminate\Http\Request;

class InstallmentService 
{

    function __construct(private Installment $installment) {}

    
    public function store(Request $request)
    {
        $this->installment->create($request->validated());
        return back()->with('message', __('app.create_successful', ['attribute' => __('app.installment')]));
    }
}