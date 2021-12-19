<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsWithYesnoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions_with_yesno', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('question_id');
            $table->integer('question_category_id')->default('0')->comment('PK of questions_cateogy. this is the parent question.');
            $table->char('ans_option', 3)->default('0')->comment('selected option ( yes or no)');
            $table->integer('category_question_id')->default('0')->comment('master question id to show based on the answer option. (PK of category_questions)');
            $table->integer('ans_question_category_id')->default('0')->comment('PK of the question to ask on yes/no in question_categories');
            $table->char('active', 1)->default('Y');
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
        Schema::dropIfExists('questions_with_yesno');
    }
}
