<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('advertisment')->unsigned();
            $table->foreign('advertisment')->references('id')->on('advertisments')->onDelete('cascade');
            $table->integer('order')->unsigned();
            $table->foreign('order')->references('id')->on('orders')->onDelete('cascade');
            $table->string('plan');
            $table->integer('price');
            $table->enum('pay',['paid','unpaid']);
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
        Schema::dropIfExists('order_details');
    }
}
