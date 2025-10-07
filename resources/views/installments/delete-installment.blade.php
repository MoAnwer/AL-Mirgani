<x-header title="{{ __('app.delete') .' '. __('app.installment')}}"/>
    <x-container>
        <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authenticatin-inner">
            <div class="card px-sm-6 px-0">
                <div class="card-body">
                <form id="formAuthentication" class="mb-6" action="{{ route('installments.destroy', $installment) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <h3 class="m-5">
                        @lang('app.delete_confirm_message', [
                            'attribute' => __('app.the_installment') .' '. __('app.number', [
                                    'attribute' => $installment->number
                                ])
                        ])
                    </h3>
                    <p></p>
                    <button class="mt-10 btn btn-danger w-100" type="submit"><i class="icon-base bx bx-trash"></i> @lang('app.delete')</button>
                </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
</x-container>