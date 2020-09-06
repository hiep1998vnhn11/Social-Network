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
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('sent_id');
            $table->unsignedBigInteger('chat_id')->default(0);
            $table->text('content');
            $table->boolean('read')->default(0);
            $table->foreign('sent_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('message_rooms')->onDelete('cascade');
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
