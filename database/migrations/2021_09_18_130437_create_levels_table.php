<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('code');
            $table->integer('capacity', false, true);
            $table->unsignedBigInteger('parent_level');
            $table->foreign('parent_level')->references('id')->on('levels')->onDelete('cascade');;
            $table->unsignedBigInteger('stage_id');
            $table->foreign('stage_id')->references('id')->on('stages')->onDelete('cascade');;
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
        Schema::dropIfExists('levels');
    }
}
