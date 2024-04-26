<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Designation;
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

        // Seed banks
        $this->seedBanks();
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
}
