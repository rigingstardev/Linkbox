<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionNarrativeOutputTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_narrative_output', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('question_id');
            $table->string('narrative_output', 300);
            $table->enum('active', array('Y','N'))->defaut('Y');
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
        Schema::dropIfExists('question_narrative_output');
    }
}
