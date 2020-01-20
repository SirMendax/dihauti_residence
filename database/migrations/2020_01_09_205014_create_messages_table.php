<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->boolean('status');

            $table->bigInteger('sender_id')->unsigned();
            $table->bigInteger('recipient_id')->unsigned();
            $table->bigInteger('dialog_id')->unsigned();

            $table->text('text');

            $table->timestamps();

            $table->foreign('sender_id')
                ->references('id')
                ->on('users')->onDelete('cascade');

            $table->foreign('recipient_id')
                ->references('id')
                ->on('users')->onDelete('cascade');

            $table->foreign('dialog_id')
                ->references('id')
                ->on('dialogs')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
