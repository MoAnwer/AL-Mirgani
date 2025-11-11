<x-header title="{{ $payroll->employee->full_name }}"/>
    <x-Container>
        <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authenticatin-inner">
            <div class="card px-sm-6 px-0">
                <div class="card-body text-center">
                <form id="formAuthentication" class="mb-6" action="{{ route('payroll.destroy', $payroll) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <h3 class="m-5">@lang('app.delete_confirm_message', ['attribute' =>  __('app.payroll_details'). ' ' .$payroll->employee->full_name .' '. $payroll->month . '/'. $payroll->year])</h3>
                    <button class="mt-10 btn btn-danger btn-lg rounded-pill" type="submit"><i class="icon-base bx bx-trash"></i> @lang('app.delete')</button>
                </form>
                    <div class="text-center my-4 no-print">
                        <a href="{{ url()->previous() }}" class="btn btn-info btn-lg rounded-pill">
                            <i class='bx bx-arrow-back me-2'></i> @lang('app.back')
                        </a>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
</x-Container>