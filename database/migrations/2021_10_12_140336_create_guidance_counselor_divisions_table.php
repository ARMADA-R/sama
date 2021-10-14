<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuidanceCounselorDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guidance_counselor_divisions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guidance_counselor_id');
            $table->foreign('guidance_counselor_id')->references('id')->on('guidance_counselors')->onDelete('cascade');

            $table->unsignedBigInteger('division_id');
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');

            $table->boolean('is_temporary');
            $table->date('end_in');
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
        Schema::dropIfExists('guidance_counselor_divisions');
    }
}
