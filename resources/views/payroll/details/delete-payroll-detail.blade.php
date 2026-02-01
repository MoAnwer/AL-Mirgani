<x-header title="{{ __('app.delete') .' '. __('app.detail') . ' ' . $detail->item->name}}"/>
    <x-Container>
        <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authenticatin-inner">
            <div class="card px-sm-6 px-0">
                <div class="card-body">
                <form id="formAuthentication" class="mb-6" action="{{ route('payroll.details.destroy', $detail->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <h3 class="m-5">@lang('app.delete_confirm_message', ['attribute' => $detail->name])</h3>
                    <button class="mt-10 btn btn-danger w-50" type="submit"><i class="icon-base bx bx-trash"></i> @lang('app.delete')</button>
                    <a href="{{ url()->previous() }}" class="mt-10 btn btn-secondary w-50">@lang('app.back')</a>
                </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
</x-Container>