<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('keywords')->nullable();
            $table->text('short_text')->nullable();
            $table->longText('content');
            $table->string('slug')->unique();
            $table->string('thumbnail')->nullable();
            $table->enum('type', ['blog', 'page', 'section'])->default('blog');
            $table->unsignedInteger('views')->default('0');
            $table->integer('parent')->unsigned();
            $table->foreign('parent')->references('id')->on('pages');
            $table->string('parent_model');
            $table->unsignedBigInteger('user_id')->nullable();
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
        Schema::dropIfExists('pages');
    }
}
