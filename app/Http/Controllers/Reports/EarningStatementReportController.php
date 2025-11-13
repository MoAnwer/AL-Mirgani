<?php

namespace App\Http\Controllers\Reports;

use App\Enums\ExpenseCategoryEnum;
use App\Http\Controllers\Controller;
use App\Models\{Earning, Expense, School};

class EarningStatementReportController extends Controller
{

    function __construct(
        private Expense $expense, 
        private Earning $earning, 
        private School $school
    ) {}

    public function generateIncomeStatement()
    {
        $school_id = request()->query('school_id') ?? 0;

        $startDate = request()->query('start_date') ?? date('Y-m-d', strtotime(now()->startOfYear()->toString()));

        $endDate = request()->query('end_date') ??  date('Y-m-d', strtotime(now()->endOfYear()->toString()));

        $incomes = $this->earning
                            ->when($school_id != 0, function($q) use ($school_id) {
                                $q->where('school_id', $school_id);
                            })
                            ->whereBetween('date', [$startDate, $endDate])
                            ->get();

        $totalFeesRevenue = $incomes->sum('amount');
        
        $totalOperatingRevenue = $totalFeesRevenue;

        $data = $this->getExpenses($school_id, $startDate, $endDate);

        $interestExpense        = array_sum($data['non_operating_expenses']);

        $totalOperatingExpenses = array_sum($data['operating_expenses']);

        $netOperatingIncome = $totalOperatingRevenue - $totalOperatingExpenses;

        $netProfit = $netOperatingIncome - $interestExpense;
        
        return view('reports.income_statement', [
            'revenue'                   => $this->revenue($totalFeesRevenue, $totalOperatingRevenue),
            'period'                    => " {$startDate} ". __('app.to') ." {$endDate}",
            'operating_expenses'        => $this->operatingExpenses($data['operating_expenses']),
            'total_operating'           => $totalOperatingExpenses,
            'non_operating_expenses'    => $this->nonOperatingExpenses($data['non_operating_expenses']),
            'interest'                  => $interestExpense,
            'netOperatingIncome'        => $netOperatingIncome,
            'netProfit'                 => $netProfit,
            'schools'                   => $this->school->pluck('name', 'id'),
            'selected_school'           => $this->school->find($school_id) ?? null
        ]);
    }


    private function getExpenses(int $school_id, $startDate, $endDate): array 
    {
        $data = [
            'operating_expenses' => [
                   "salaries"               => 0,
                    "rents"                 => 0,
                    "electricityAndWater"   => 0,
                    "maintenance"           => 0,
                    "incentives"            => 0,
                    "furniture"             => 0,
            ],
            'non_operating_expenses' => [
                'books'         => 0,
                'buffet'        => 0,
                'helps'         => 0,
                'interBranch'   => 0,
                'management'    => 0,
                'printExams'    => 0,
                'travel'        => 0,
                'uniform'       => 0,
                'schools'       => 0,
                'tools'         => 0,
                'other'         => 0,
            ], 
        ];

        $this->expense
            ->selectRaw('expenses.school_id as school_id, category_id, expense_categories.name as name, SUM(amount) as amount')
            ->join('expense_categories', 'expense_categories.id', 'expenses.category_id')
            ->groupBy('category_id')
            ->when($school_id != 0, function($q) use ($school_id) {
                $q->where('school_id', $school_id);
            })
            ->whereBetween('date', [$startDate, $endDate])
            ->get()
            ->map(function($n) use (&$data) {
                return match ($n['name']) {
                    ExpenseCategoryEnum::SALARIES->value                => $data['operating_expenses']['salaries'] = $n['amount'],
                    ExpenseCategoryEnum::INCENTIVES->value              => $data['operating_expenses']['incentives'] = $n['amount'],
                    ExpenseCategoryEnum::RENTS->value                   => $data['operating_expenses']['rents'] = $n['amount'],
                    ExpenseCategoryEnum::FURNITURE->value               => $data['operating_expenses']['furniture'] = $n['amount'],
                    ExpenseCategoryEnum::ELECTRICITY_AND_WATER->value   => $data['operating_expenses']['electricityAndWater'] = $n['amount'],
                    ExpenseCategoryEnum::UPKEEP->value                  => $data['operating_expenses']['maintenance'] = $n['amount'],

                    ExpenseCategoryEnum::BOOKS->value                   => $data['non_operating_expenses']['books'] = $n['amount'],
                    ExpenseCategoryEnum::BUFFET->value                  => $data['non_operating_expenses']['buffet'] = $n['amount'],
                    ExpenseCategoryEnum::HELPS->value                   => $data['non_operating_expenses']['helps'] = $n['amount'],
                    ExpenseCategoryEnum::INTER_BRANCH->value            => $data['non_operating_expenses']['interBranch'] = $n['amount'],
                    ExpenseCategoryEnum::MANAGEMENT->value              => $data['non_operating_expenses']['management'] = $n['amount'],
                    ExpenseCategoryEnum::PRINT_EXAMS->value             => $data['non_operating_expenses']['printExams'] = $n['amount'],
                    ExpenseCategoryEnum::TRAVEL->value                  => $data['non_operating_expenses']['travel'] = $n['amount'],
                    ExpenseCategoryEnum::UNIFORM->value                 => $data['non_operating_expenses']['uniform'] = $n['amount'],
                    ExpenseCategoryEnum::SCHOOLS->value                 => $data['non_operating_expenses']['schools'] = $n['amount'],
                    ExpenseCategoryEnum::TOOLS->value                   => $data['non_operating_expenses']['tools'] = $n['amount'],
                    ExpenseCategoryEnum::OTHER->value                   => $data['non_operating_expenses']['other'] = $n['amount'],
                    default => ''
                };
            });

        return $data;
    }

    private function revenue(int $totalFeesRevenue, int $totalOperatingRevenue): array 
    {
        return [
            'fees' => $totalFeesRevenue,
            'total' => $totalOperatingRevenue,
        ];
    }

    private function operatingExpenses(array $data): array 
    {
        return [
            'salaries'                  => [$data['salaries'], __('app.employees_salaries')],
            'electricityAndWaterExpense'=> [$data['electricityAndWater'], __('expenses.'.ExpenseCategoryEnum::ELECTRICITY_AND_WATER->value . '')],
            'furnitureExpense'          => [$data['furniture'], __('expenses.'.ExpenseCategoryEnum::FURNITURE->value . '')],
            'rent'                      => [$data['rents'], __('expenses.'.ExpenseCategoryEnum::RENTS->value . '')],
            'maintenance'               => [$data['maintenance'], __('expenses.'.ExpenseCategoryEnum::UPKEEP->value . '')],
        ];
    }


    private function nonOperatingExpenses($data): array 
    {
        return [
            'booksExpense'              => [$data['books'], __('expenses.'.ExpenseCategoryEnum::BOOKS->value . '')],
            'buffetExpense'             => [$data['buffet'], __('expenses.'.ExpenseCategoryEnum::BUFFET->value . '')],
            'helpsExpense'              => [$data['helps'], __('expenses.'.ExpenseCategoryEnum::HELPS->value . '')],
            'interBranchExpense'        => [$data['interBranch'], __('expenses.'.ExpenseCategoryEnum::INTER_BRANCH->value . '')],
            'managementExpense'         => [$data['management'], __('expenses.'.ExpenseCategoryEnum::MANAGEMENT->value . '')],
            'printExamsExpense'         => [$data['printExams'], __('expenses.'.ExpenseCategoryEnum::PRINT_EXAMS->value . '')],
            'travelExpense'             => [$data['travel'], __('expenses.'.ExpenseCategoryEnum::TRAVEL->value . '')],
            'uniformExpense'            => [$data['uniform'], __('expenses.'.ExpenseCategoryEnum::UNIFORM->value . '')],
            'schoolsExpense'            => [$data['schools'], __('expenses.'.ExpenseCategoryEnum::SCHOOLS->value . '')],
            'toolsExpense'              => [$data['tools'], __('expenses.'.ExpenseCategoryEnum::TOOLS->value . '')],
            'othersExpense'             => [$data['other'], __('expenses.'.ExpenseCategoryEnum::OTHER->value . '')],
        ];
    }
}
