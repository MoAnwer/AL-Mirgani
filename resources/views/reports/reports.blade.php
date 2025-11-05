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
                        <x-cards.card link="{{ route('accounts') }}" icon="bx bx-book-open" title=" كشف الحساب " description="الرصيد المرحل و الايرادات و المنصرفات ليوم معين"/>
                        <x-cards.card link="{{ route('payroll.summary.report') }}" icon="bx bx-box" title="  تقرير كشوف الرواتب " description="الإجماليات المُعالجة حسب الشهر و العام"/>
                        <x-cards.card link="{{ route('arrears.all') }}" icon="bx bx-money" title=" الأقساط المتأخرة" description="نظرة عامة عن متاخرات الاقساط"/>
                        <x-cards.card link="{{ route('revenues') }}" icon='bx bxs-bar-chart-alt-2' title="ايرادات حسب الصف" description="تحليل الإيرادات حسب الصف للمرحلة كل المدارس"/>
                        <x-cards.card link="{{ route('reports.general-expense-report') }}" icon='bx bx-wallet' title="إجمالي المصروفات العامة للمدرسة" description="الإجمالي الكلي للمصروفات التشغيلية والمدرسية ."/>
                        <x-cards.card link="{{ route('incomeReport') }}" icon='bx bxs-bar-chart-alt-2' title="قائمة الدخل" description=" الإيرادات و المصروفات التشغيلية و صافي الربح"/>

                        <x-cards.card link="{{ route('reports.employee-count-report') }}" icon='bx bxs-briefcase' title="توزيع الموظفين حسب القسم" description="نظرة عامة دقيقة على القوى العاملة حسب المهنة."/>
                    </x-cards.cards-container>
                </div>
            </x-container>
        </x-layout-container>
    </x-layout-page>
</x-layout-wrapper>
<x-footer />