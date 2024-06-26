<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'employees', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('name');
            $table->date('dob')->nullable();
            $table->string('gender');
            $table->string('phone')->nullable();
            $table->string('address');
            $table->string('email');
            $table->string('password');

            $table->string('employee_id');
            $table->integer('branch_id');
            $table->integer('department_id');
            $table->integer('designation_id');
            $table->string('company_doj')->nullable();
            $table->string('documents')->nullable();

            $table->string('account_holder_name')->nullable();
            $table->string('account_number')->nullable();
            $table->bigInteger('bank_id')->unsigned();
            $table->string('bank_identifier_code')->nullable();
            $table->string('branch_location')->nullable();
            $table->string('tax_payer_id')->nullable();
            $table->integer('salary_type')->nullable();
            $table->integer('account_type')->nullable();
            $table->float('salary', 20, 2)->default(0.00);
            $table->integer('is_active')->default('1');
            $table->integer('created_by');
            $table->timestamps();

            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('set null');
        }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
