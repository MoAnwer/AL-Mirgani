<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
    <a href="{{ route('dashboard') }}" class="app-brand-link mt-3">
        <span class="app-brand-logo"></span>
        <span class="demo fw-bold ms-2">{{ __('app.app_name') }}</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="bx bx-chevron-left d-block d-xl-none align-middle"></i>
    </a>
    </div>

    <div class="menu-divider mt-0"></div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
    
        <x-Menu.MenuItem route="dashboard" label="لوحة التحكم" icon="menu-icon tf-icons icon-base bx bx-home-alt" />
        
        <x-Menu.MenuItem route="students.index" label="التلاميذ" icon="tf-icons bx bx-group me-2" classes='menu-toggle' >
            <x-Menu.MenuSub>
                <x-Menu.MenuItem label="{{ __('app.register_new_student') }}" route="students.create"/>
                <x-Menu.MenuItem label="{{ __('app.list', ['attribute' => __('app.the_students')]) }}" route="students.index"/>
                <x-Menu.MenuItem label="{{ __('app.count_of', ['count' => __('app.the_students')]) }}" route="students.count-report"/>
            </x-Menu.MenuSub>
        </x-Menu.MenuItem>
        
        <x-Menu.MenuItem label="{{ __('app.the_employees') }}" icon="tf-icons bx bxl-microsoft-teams" classes='menu-toggle'>
            <x-Menu.MenuSub>
                <x-Menu.MenuItem label="{{ __('app.list', ['attribute' => __('app.the_employees')]) }}" route="employees.index"/>
                    <x-Menu.MenuItem label="{{ __('app.create', ['attribute' => __('app.employee')]) }}" route="employees.create"/>
            </x-Menu.MenuSub>
        </x-Menu.MenuItem>

        <x-Menu.MenuItem label="{{ __('app.the_schools') }}" icon="tf-icons bx bxs-school" classes='menu-toggle'>
            <x-Menu.MenuSub>
                <x-Menu.MenuItem label="{{ __('app.list', ['attribute' => __('app.the_schools')]) }}" route="schools.index"/>
                    <x-Menu.MenuItem label="اضافة مدرسة جديدة" route="schools.create"/>
            </x-Menu.MenuSub>
        </x-Menu.MenuItem>



        <x-Menu.MenuHeader title="{{ __('app.payrolls') }}"/>

        <x-Menu.MenuItem label="{{ __('app.payrolls_report') }}" route="payroll.index" icon="bx bx-money" />
        <x-Menu.MenuItem label="{{ __('app.create_payroll_scan') }}" route="payroll.create" icon="bx bx-book-bookmark" /> 
        <x-Menu.MenuItem label="{{ __('app.payroll_items') }}" route="payroll_items.index" icon="bx bx-food-menu" />

        <x-Menu.MenuHeader title="{{ __('app.accounts') }}"/>

        <x-Menu.MenuItem label="{{ __('app.account_scan') }}" icon="bx bx-book-open" route="accounts"/>

        <x-Menu.MenuItem label="{{ __('app.the_reports') }}" icon="bx bx-news" route="reports"/>

        <x-Menu.MenuItem label="{{ __('app.the_expenses') }}" icon="bx bx-money" classes='menu-toggle'>
            <x-Menu.MenuSub>
                <x-Menu.MenuItem label="{{ __('app.list',   ['attribute' => __('app.the_expenses')]) }}" route="expenses.index"/>
                <x-Menu.MenuItem label="{{ __('app.create', ['attribute' => __('app.expense')]) }}" route="expenses.new"/>
            </x-Menu.MenuSub>
        </x-Menu.MenuItem>

        <x-Menu.MenuItem label="{{ __('app.the_earnings') }}" icon="bx bxs-bar-chart-alt-2" classes='menu-toggle'>
            <x-Menu.MenuSub>
                <x-Menu.MenuItem label="{{ __('app.list',   ['attribute' => __('app.the_earnings')]) }}" route="earnings.index"/>
                <x-Menu.MenuItem label="{{ __('app.create', ['attribute' => __('app.earning')]) }}" route="earnings.create"/>
            </x-Menu.MenuSub>
        </x-Menu.MenuItem>


        <x-Menu.MenuHeader title="{{ __('app.settings') }}"/>
        <x-Menu.MenuItem icon="bx bx-user" label="{{ __('app.users') }}" route="users.index" />
        <x-Menu.MenuItem icon="bx bx-cog" label="{{ __('app.settings') }}" />
    </ul>
</aside>