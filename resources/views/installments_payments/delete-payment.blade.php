<x-header title="{{ __('app.delete') .' '. __('app.payment') . ' ' . __('app.installment') }}"/>
    <x-container>
        <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="card px-0">
                <div class="card-body">
                <form id="formAuthentication" class="mb-6" action="{{ route('installments.payments.destroy', $payment) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <h4 class="m-5">@lang('app.delete_confirm_message', [
                            'attribute' => __('app.payment') . ' ' .  __('app.the_installment') . ' ' . $payment->installment->number
                        ])
                    </h4>
                    <p class="px-5 text-center">
                        القسط خاص بالتلميذ {{ $payment->installment->student->full_name }}
                    </p>
                    <button class="mt-10 btn btn-danger w-100" type="submit"><i class="icon-base bx bx-trash"></i> @lang('app.delete')</button>
                </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
</x-container>