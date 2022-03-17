<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_budgets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('expense_id')->onUpdate()->constrained();
            $table->double('budget_bal', 10,2)->default(0.00);
            $table->double('prior_exp', 10,2)->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expense_budgets');
    }
}
