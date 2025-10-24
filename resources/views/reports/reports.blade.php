<x-header title="{{ __('app.the_reports') }}" />
<style>
    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
    }
</style>
<x-layout-wrapper>
    <x-aside />
    <x-layout-page>
        <x-nav />
        <x-layout-container>
            <x-container>
                <div class="dashboard-container">
                    <h3 class="mb-5">التقارير المالية 💰</h3>
                    <x-cards.cards-container>
                        <x-cards.card link="{{ route('arrears.all') }}" icon="bx bx-money" title=" الأقساط المتأخرة" description="نظرة عامة عن متاخرات الاقساط"/>
                        <x-cards.card link="{{ route('revenues.schools', 1) }}" icon='bx bxs-bar-chart-alt-2' title="ايرادات حسب الصف للمدرسة الابتدائية" description="ايرادات حسب الصف للمدرسة الابتدائية"/>
                        <x-cards.card link="{{ route('revenues.schools', 2) }}" icon='bx bxs-bar-chart-alt-2' title="ايرادات حسب الصف للمدرسة المتوسطة" description="ايرادات حسب الصف للمدرسة المتوسطة"/>
                        <x-cards.card link="{{ route('incomeReport') }}" icon='bx bxs-bar-chart-alt-2' title="قائمة الدخل" description="قائمة الدخل"/>
                    </x-cards.cards-container>
                </div>
            </x-container>
        </x-layout-container>
    </x-layout-page>
</x-layout-wrapper>
<x-footer />