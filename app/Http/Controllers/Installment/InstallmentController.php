<?php

namespace App\Http\Controllers\Installment;

use App\Http\Controllers\Controller;
use App\Services\Installment\InstallmentService;
use App\Http\Requests\Installment\{StoreInstallmentRequest, UpdateInstallmentRequest};
use App\Models\Installment;

class InstallmentController extends Controller
{
    public function __construct(private InstallmentService $service) {}

    /**
     * @param string $id this is refer to student id
     */
    public function create(string $id)
    {
        return $this->service->create($id);
    }

    public function store(StoreInstallmentRequest $request)
    {
        return $this->service->store($request);
    }

    public function edit(Installment $installment) {
        return view('installments.edit-installment-form', compact('installment'));
    }

    public function update(Installment $installment, UpdateInstallmentRequest $request) {
        return $this->service->update($installment, $request);
    }

    public function delete(Installment $installment)
    {
        return view('installments.delete-installment', compact('installment'));
    }

    public function destroy(Installment $installment) 
    {
        return $this->service->destroy($installment);
    }
}
