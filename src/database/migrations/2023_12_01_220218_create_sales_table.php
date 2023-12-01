<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('client', 255);
            $table->date('operation_date');
            $table->date('expiration_date');
            $table->string('payment_condition', 255);
            $table->string('currency', 3);
            $table->json('sale_detail');
            $table->float('subtotal')->default(0);
            $table->float('igv')->default(0);
            $table->float('total')->default(0);
            $table->text('comment')->nullable();
            $table->unsignedBigInteger('user_id')->comment('Created By User');

            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('sales');
    }
};
