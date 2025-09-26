<x-header title="{{ $title }}" />

<x-LayoutWrapper>
    <x-LayoutContainer>
        <x-aside />
        <x-LayoutPage>
            <x-nav />
            <x-ContentWrapper>
                <x-Container>
                    <div class="row row g-6 mb-6">

                        <div class="col-md-12">

                            <div class="card container">
                                <h4 class="card-header">{{ $title }}</h4>

                                <div class="card-body demo-vertical-spacing demo-only-element">

                                    <form action="{{ route('students.store') }}" method="POST">
                                    
                                    @csrf
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="اسم الطالب الرباعي"  name="full_name"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="العنوان"  name="address"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-select">
                                                @foreach($stages as $value)
                                                    <option value="{{ $value }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <select class="form-select">
                                                @foreach($schools as $value)
                                                    <option value="{{ $value }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <div class="input-group">
                                                <input type="number" class="form-control" placeholder="الرسوم الدراسية"  name="total_fee"/>
                                            </div>
                                        </div>
                                        
                                        <div class=" mt-5">
                                            <h5>بيانات ولي الامر</h5>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="الاسم ولي الامر"  name="parent_name"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" placeholder="رقم الهاتف 1"  name="phone_one"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" placeholder="رقم الهاتف 2"  name="phone_two"/>
                                                    </div>
                                                </div>

                                            </div>
                                            </div>
                                        </div>
                                        <button type="submit" class=" mt-4 btn btn-primary">اضافة</button>
                                    </form>
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