<x-header title="{{ __('app.delete') .' '. __('app.user') . ' '  . $user->name}}" />
<x-container>
    <div class="container">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authenticatin-inner">
                <div class="card px-sm-6 px-0">
                    <div class="card-body">
                        <form class="mb-6" action="{{ route('users.destroy', $user) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <h3 class="m-5 text-center">@lang('app.delete_confirm_message', ['attribute' => __('app.user').' '.$user->name])</h3>
                            <button class="mt-10 btn btn-danger w-100" type="submit"><i class="icon-base bx bx-trash"></i> @lang('app.delete')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-container>
