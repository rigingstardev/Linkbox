<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientPracticeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_practice', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('patient_id');
            $table->smallInteger('practice_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('practice_id')->references('id')->on('practice')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->auditable();
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
        Schema::dropIfExists('patient_practice');
    }
}
