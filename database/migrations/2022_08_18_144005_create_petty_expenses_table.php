<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePettyExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petty_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->onDelete('cascade')->constrained();
            $table->string('exp_no');
            $table->string('description');
          // $table->string('req_by');
            $table->string('prep_by');
            $table->string('apprv_by')->nullable();
            $table->double('total', 10, 2);
            $table->string('dept');
            $table->text('comment')->nullable();
            $table->integer('hod_apprv')->default(0);
            $table->integer('cfo_apprv')->default(0);
            $table->integer('paymt_apprv')->default(0);
            $table->string('invoice')->nullable();
          //  $table->string('signature');
            $table->enum('status', ['APPROVED', 'DECLINED', 'HOLDING', 'PENDING'])->default('PENDING');
            $table->enum('pay_status', ['PAID', 'NOT PAID'])->default('NOT PAID');
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
        Schema::dropIfExists('petty_expenses');
    }
}
