<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_account_id');
            $table->foreign('parent_account_id')->references('id')->on('parent_accounts');
            $table->text('message');
            $table->string('type');
            $table->dateTime('read_at');
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
        Schema::dropIfExists('parent_notifications');
    }
}
