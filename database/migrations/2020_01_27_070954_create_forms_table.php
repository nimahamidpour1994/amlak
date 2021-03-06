<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('field')->unsigned();
            $table->foreign('field')->references('id')->on('categories');
            $table->text('value')->nullable();
            $table->string('unit')->nullable();
            $table->integer('force')->default(1);
            $table->integer('show_thumbnail')->default(0);
            $table->integer('parent')->unsigned();
            $table->foreign('parent')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forms');
    }
}
