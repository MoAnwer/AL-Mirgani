<x-header title="عدد التلاميذ"/>
<style>
/* Cards Grid Layout */
.cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 5px;
}
/* Card Styling */
    .card {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 30px;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        display: flex; /* Align icon and content */
        align-items: flex-start;
        border: 1px solid #e0e0e0; /* Subtle border */
    }

    /* Icon Styling */
    .card-icon {
        font-size: 25px;
        color: #007bff; /* Primary blue color for icon */
        margin-left: 20px; /* Space between icon and text in RTL */
        padding: 10px;
        background-color: #e6f0ff; /* Light background for icon */
        border-radius: 8px;
        line-height: 1; /* Ensure icon is vertically centered */
        flex-shrink: 0; /* Prevent icon from shrinking */
    }

    /* Content Styling */
    .card-content h3 {
        margin-top: 10px;
        color: #1a237e; /* Dark blue for title */
        font-size: 20px;
        margin-bottom: 4px;
        font-weight: 600;
    }

    .card-content p {
        color: #555; /* Gray for description */
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
                        <h3 class="mb-5">عدد التلاميذ حسب المدرسة</h3>
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
                        
                        <h3 class="mb-5">عدد التلاميذ حسب الصف</h3>
                        <div class="cards-grid">
                            @foreach ($countByClass as $class)
                                <div class="card my-1 mx-1">
                                    <div class="card-icon">
                                        <span>{{ $class->count }}</span>
                                    </div>
                                    <div class="card-content">
                                        <h3>{{ $class->name }}</h3>
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
