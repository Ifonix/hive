<?php

namespace Database\Seeders;

use App\Models\AccountList;
use App\Models\AllowanceOption;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\DeductionOption;
use App\Models\Department;
use App\Models\Designation;
use App\Models\PayslipType;
use Illuminate\Database\Seeder;

class HrmSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $aBranches = ['Colombo', 'Kandy', 'Kaluthara', 'Galle', 'Uva'];
        foreach ($aBranches as $key => $branch) {
            $oBranch = Branch::create([
                'name' => $branch,
                'created_by' => 2
            ]);

            if ($key < 3 && $branch === 'Colombo') {
                $this->seedDepartments($oBranch, ['IT', 'Management', 'Accounting']);
            } elseif ($key < 2 && $branch === 'Kandy') {
                $this->seedDepartments($oBranch, ['Marketing', 'Sales']);
            }
        }

        // Seeders
        $this->seedBanks();
        $this->seedPayslips();
        $this->seedAllowance();
        $this->seedDeduction();
        $this->seedAccount();
    }

    /**
     * Seed departments for a given branch.
     *
     * @param  \App\Models\Branch  $branch
     * @param  array  $departments
     * @return void
     */
    private function seedDepartments(Branch $branch, array $departments): void
    {
        foreach ($departments as $department) {
            $oDepartment = Department::create([
                'branch_id' => $branch->id,
                'name' => $department,
                'created_by' => 2
            ]);

            // Seed designations based on department
            $this->seedDesignations($oDepartment);
        }
    }

    /**
     * Seed designations based on department name.
     *
     * @param  \App\Models\Department  $department
     * @return void
     */
    private function seedDesignations(Department $department): void
    {
        $departmentName = strtolower($department->name);

        switch ($departmentName) {
            case 'it':
                $designations = ['Software Engineer', 'QA Engineer', 'System Administrator'];
                break;
            case 'management':
                $designations = ['Manager', 'Assistant Manager', 'Executive'];
                break;
            case 'accounting':
                $designations = ['Accountant', 'Financial Analyst', 'Accounts Clerk'];
                break;
            case 'marketing':
                $designations = ['Marketing Manager', 'Marketing Executive', 'Marketing Assistant'];
                break;
            case 'sales':
                $designations = ['Sales Manager', 'Sales Executive', 'Sales Representative'];
                break;
            default:
                $designations = ['Employee', 'Trainee'];
        }

        foreach ($designations as $designation) {
            Designation::create([
                'department_id' => $department->id,
                'name' => $designation,
                'created_by' => 2
            ]);
        }
    }

    /**
     * Seed banks.
     *
     * @return void
     */
    private function seedBanks(): void
    {
        $banks = ['NTB', 'BOC', 'Commercial', 'HNB', 'Peoples Bank'];
        foreach ($banks as $bank) {
            Bank::create([
                'name' => $bank,
                'created_by' => 2
            ]);
        }
    }

    /**
     * Seed payslips.
     *
     * @return void
     */
    private function seedPayslips(): void
    {
        $aPayslips = ['Grade A', 'Grade B', 'Grade C'];
        foreach ($aPayslips as $payslip) {
            PayslipType::create([
                'name' => $payslip,
                'created_by' => 2
            ]);
        }
    }

    /**
     * Seed allowance.
     *
     * @return void
     */
    private function seedAllowance(): void
    {
        $aAllowance = ['Travelling Allowance', 'Attendance Allowance', 'Food Allowance'];
        foreach ($aAllowance as $allowance) {
            AllowanceOption::create([
                'name' => $allowance,
                'created_by' => 2
            ]);
        }
    }

    /**
     * Seed deduction.
     *
     * @return void
     */
    private function seedDeduction(): void
    {
        $aDeduction = ['Welfare Deduction', 'Travelling Deduction', 'Stationary Deduction'];
        foreach ($aDeduction as $deduction) {
            DeductionOption::create([
                'name' => $deduction,
                'created_by' => 2
            ]);
        }
    }

    /**
     * Seed account.
     *
     * @return void
     */
    private function seedAccount(): void
    {
        $aAccounts = [
            0 => [
                'account_name' => 'Sample Account 1',
                'initial_balance' => 100000,
                'account_number' => 'ABC123456789',
                'branch_code' => '1',
                'bank_branch' => 'Sample Bank Branch 1',
                'created_by' => 2
            ],
            1 => [
                'account_name' => 'Sample Account 2',
                'initial_balance' => 5000000,
                'account_number' => 'XYZ987654321',
                'branch_code' => '2',
                'bank_branch' => 'Sample Bank Branch 2',
                'created_by' => 2
            ]
        ];
        foreach ($aAccounts as $accounts) {
            AccountList::create($accounts);
        }
    }
}
