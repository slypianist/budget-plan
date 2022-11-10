<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePettyExpenseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petty_expense_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petty_expense_id')->onDelete('cascade')->constrained();
            $table->string('item');
            $table->double('qty');
            $table->double('rate');
            $table->double('amount');
          //  $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('petty__expense_items');
    }
}
