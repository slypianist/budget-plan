<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->onUpdate('cascade')->constrained();
            $table->foreignId('budget_id')->onUpdate('cascade')->nullable()->constrained();
            $table->string('description');
            $table->text('comment')->nullable();
            $table->double('total',10, 2)->default(0.00);
            $table->double('budget_exp_bal', 10, 2)->nullable();
            $table->integer('exp_index')->default(0);
            $table->integer('apv_hod');
            $table->integer('hod_approval')->default(0);
            $table->integer('cfo_approval')->default(0);
            $table->integer('budget_cleared')->default(0);
            $table->integer('md_approval')->default(0);
            $table->string('hod_comment')->nullable();
            $table->string('bo-comment')->nullable();
            $table->string('cfo_comment')->nullable();
            $table->string('md_comment')->nullable();
            $table->enum('status', ['APPROVED', 'DECLINED', 'HOLDING', 'PENDING'])->default('PENDING');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}
