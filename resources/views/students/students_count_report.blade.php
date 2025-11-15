<x-header title="{{ __('app.count_of', ['count' => __('app.the_students') ]) }}"/>
<style>
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 5px;
    }
    .card {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 30px;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        display: flex; 
        align-items: flex-start;
        border: 1px solid #e0e0e0; 
    }

    .card-icon {
        font-size: 25px;
        color: #007bff; 
        margin-left: 20px; 
        padding: 10px;
        background-color: #e6f0ff; 
        border-radius: 8px;
        line-height: 1;
        flex-shrink: 0;
    }


    .card-content h3 {
        margin-top: 10px;
        color: #1a237e; 
        font-size: 20px;
        margin-bottom: 4px;
        font-weight: 600;
    }

    .card-content p {
        color: #555; 
        line-height: 1.6;
        font-size: 15px;
    }
</style>
    <x-LayoutWrapper>
        <x-LayoutContainer>
            <x-aside />
            <x-LayoutPage>
                <x-nav />
                <x-ContentWrapper>
                    <x-Container>
                        <h3 class="mb-5">@lang('app.count_of_students_by_school')</h3>
                        <div class="cards-grid">
                            @foreach ($countBySchool as $school)
                                <div class="card my-1 mx-1">
                                    <div class="card-icon">
                                        <span>{{ $school->count }}</span>
                                    </div>
                                    <div class="card-content">
                                        <h3>{{ $school->name }}</h3>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <hr />
                        
                        <h3 class="mb-5">@lang('app.count_of_students_by_class')</h3>
                        <div class="cards-grid">
                            @foreach ($countByClass as $class)
                                <div class="card my-1 mx-1">
                                    <div class="card-icon">
                                        <span>{{ $class->count }}</span>
                                    </div>
                                    <div class="card-content">
                                        <h3>{{ __("classes.{$class->name}") }}</h3>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </x-Container>
                </x-ContentWrapper>
            </x-LayoutPage>
        </x-LayoutContainer>
    </x-LayoutWrapper>
<x-footer />
