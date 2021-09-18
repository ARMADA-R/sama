<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentExamGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_exam_grades', function (Blueprint $table) {
            $table->id();
            $table->double('grade');
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('students');
            $table->unsignedBigInteger('material_id');
            $table->foreign('material_id')->references('id')->on('study_materials');
            $table->unsignedBigInteger('semester_exam_id');
            $table->foreign('semester_exam_id')->references('id')->on('semester_exams');
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
        Schema::dropIfExists('student_exam_grades');
    }
}
