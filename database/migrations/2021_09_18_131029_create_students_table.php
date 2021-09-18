<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birth_date');
            $table->string('birth_place');
            $table->enum('gender', ['male', 'female']);
            $table->string('city');
            $table->string('street');
            $table->string('area');
            $table->string('phone');
            $table->string('mobile');
            $table->string('emergency_phone');
            $table->string('emergency_kinship');
            $table->unsignedBigInteger('religion_id');
            $table->foreign('religion_id')->references('id')->on('religions');
            $table->unsignedBigInteger('mother_id');
            $table->foreign('mother_id')->references('id')->on('parents');
            $table->unsignedBigInteger('father_id');
            $table->foreign('father_id')->references('id')->on('parents');
            $table->unsignedBigInteger('division_id');
            $table->foreign('division_id')->references('id')->on('divisions');

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
        Schema::dropIfExists('students');
    }
}
