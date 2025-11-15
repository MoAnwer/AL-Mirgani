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
                    <h3 class="mb-5">@lang('app.the_reports')</h3>
                    <x-cards.cards-container>
                        <x-cards.card link="{{ route('accounts') }}" icon="bx bx-book-open" title="{{ __('app.account_statement') }}" description="{{ __('app.account_statement_description') }}"/>
                        <x-cards.card link="{{ route('payroll.summary.report') }}" icon="bx bx-box" title="{{ __('app.payrolls_report') }}" description="{{ __('app.payroll_report_description') }}"/>
                        <x-cards.card link="{{ route('arrears.all') }}" icon="bx bx-money" title="{{ __('app.arrears_installments') }}" description="{{ __('app.arrears_installments_description') }}"/>
                        <x-cards.card link="{{ route('revenues') }}" icon='bx bxs-bar-chart-alt-2' title="{{ __('app.revenues_by_class_report') }}" description="{{ __('app.revenues_by_class_description') }}"/>
                        <x-cards.card link="{{ route('reports.general-expense-report') }}" icon='bx bx-wallet' title="{{ __('app.total_expenses_report') }}" description="{{ __('app.total_expenses__description') }}"/>
                        <x-cards.card link="{{ route('incomeReport') }}" icon='bx bx-calculator' title="{{ __('app.income_statement') }}" description="{{ __('app.income_statement_description') }}"/>
                        <x-cards.card link="{{ route('reports.employee-count-report') }}" icon='bx bxs-briefcase' title="{{ __('app.employee_report') }}" description="{{ __('app.employee_report_description') }}"/>
                        <x-cards.card link="{{ route('students.count-report') }}" icon='bx bxs-user-account' title="{{ __('app.count_of', ['count' => __('app.the_students') ]) }}" description="{{ __('app.count_of_students_by_school') . ' , ' . __('app.count_of_students_by_class') }}"/>
                    </x-cards.cards-container>
            </x-container>
        </x-layout-container>
    </x-layout-page>
</x-layout-wrapper>
<x-footer />