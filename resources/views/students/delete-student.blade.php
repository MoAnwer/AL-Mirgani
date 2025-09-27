<x-header title="{{ __('app.delete') .' '. __('app.student') . ' '  . $student->full_name}}"/>
    <x-Container>
                <div class="container-xxl">
                <div class="authentication-wrapper authentication-basic container-p-y">
                    <div class="authenticatin-inner">
                    <div class="card px-sm-6 px-0">
                        <div class="card-body">
                        <form id="formAuthentication" class="mb-6" action="{{ route('students.destroy', $student->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <h3 class="m-5">@lang('app.delete_confirm_message', ['attribute' => $student->full_name])</h3>
                            <button class="btn btn-danger d-grid w-100" type="submit">تسجيل الدخول</button>
                        </form>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </x-Container>