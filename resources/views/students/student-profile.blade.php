<x-header title="{{ __('app.app-name') }}"/>

<x-LayoutWrapper>
    <x-LayoutContainer>
        <x-aside />
        <x-LayoutPage>
            <x-nav />
            <x-ContentWrapper>
                <x-Container>
                    <div class="row">
                        <div class="col-md-12">
                        <div class="nav-align-top">
                            <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-md-0 gap-2">
                            <li class="nav-item">
                                <a class="nav-link active" href="javascript:void(0);"
                                ><i class="icon-base bx bx-user icon-sm me-1_5"></i> Account</a
                                >
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pages-account-settings-notifications.html"
                                ><i class="icon-base bx bx-bell icon-sm me-1_5"></i> Notifications</a
                                >
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pages-account-settings-connections.html"
                                ><i class="icon-base bx bx-link-alt icon-sm me-1_5"></i> Connections</a
                                >
                            </li>
                            </ul>
                        </div>
                        <div class="card mb-6">
                            <!-- Account -->
                            <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-6 pb-4 border-bottom">
                                <img
                                src="../assets/img/avatars/1.png"
                                alt="user-avatar"
                                class="d-block w-px-100 h-px-100 rounded"
                                id="uploadedAvatar" />
                                <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-3 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Upload new photo</span>
                                    <i class="icon-base bx bx-upload d-block d-sm-none"></i>
                                    <input
                                    type="file"
                                    id="upload"
                                    class="account-file-input"
                                    hidden
                                    accept="image/png, image/jpeg" />
                                </label>
                                <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                    <i class="icon-base bx bx-reset d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Reset</span>
                                </button>

                                <div>Allowed JPG, GIF or PNG. Max size of 800K</div>
                                </div>
                            </div>
                            </div>
                            <div class="card-body pt-4">
                                 <div class="card-body demo-vertical-spacing demo-only-element">
                                    <form action="{{ route('students.update', $student->id) }}" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                        <label class="mb-3">@lang('app.student_full_name')</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control"  name="full_name" value="{{ $student->full_name }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                        <label class="mb-3">@lang('app.address')</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="العنوان"  name="address" value="{{ $student->address }}"/>
                                            </div>
                                        </div>
                                         <div class="col-md-6 mt-3">
                                            <label class="mb-3">@lang('app.class')</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="العنوان"  name="address" value="{{ $student->class->name }}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                        <label class="mb-3">@lang('app.stage')</label>
                                           <div class="input-group">
                                                <input type="text" class="form-control" placeholder="العنوان"  name="stage" value="{{ $student->stage }}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                        <label class="mb-3">@lang('app.school')</label>
                                           <div class="input-group">
                                                <input type="text" class="form-control" placeholder="العنوان"  name="school" value="{{ $student->school->name }}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                        <label class="mb-3">الرسوم الدراسية</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control"  name="total_fee" value="{{ $student->total_fee }}"/>
                                            </div>
                                        </div>
                                        </div>
                                        <button type="submit" class="mt-4 btn btn-success">
                                            <i class="icon-base bx bx-edit-alt me-1"></i>
                                            تعديل
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <!-- /Account -->
                        </div>
                        <div class="card">
                            <h5 class="card-header">Delete Account</h5>
                            <div class="card-body">
                            <div class="mb-6 col-12 mb-0">
                                <div class="alert alert-warning">
                                <h5 class="alert-heading mb-1">Are you sure you want to delete your account?</h5>
                                <p class="mb-0">Once you delete your account, there is no going back. Please be certain.</p>
                                </div>
                            </div>
                            <form id="formAccountDeactivation" onsubmit="return false">
                                <div class="form-check my-8 ms-2">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="accountActivation"
                                    id="accountActivation" />
                                <label class="form-check-label" for="accountActivation"
                                    >I confirm my account deactivation</label
                                >
                                </div>
                                <button type="submit" class="btn btn-danger deactivate-account">Deactivate Account</button>
                            </form>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </x-Container>
            </x-ContentWrapper>
        </x-LayoutPage>
    </x-LayoutContainer>
</x-LayoutWrapper>
<x-footer/> 