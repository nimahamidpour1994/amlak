<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sender');
            $table->string('receiver');
            $table->text('message')->nullable();
            $table->enum('read',['read','unread'])->default('unread');
            $table->integer('advertisment')->unsigned();
            $table->foreign('advertisment')->references('id')->on('advertisments')->onDelete('cascade');
            $table->enum('is_start',['true','false'])->default('false');
            $table->bigInteger('tracking_code')->default(time());
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
        Schema::dropIfExists('chats');
    }
}
