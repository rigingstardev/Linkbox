<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('question_categories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index('question_categories_user_id_foreign');
			$table->integer('question_id')->unsigned()->index('question_categories_question_id_foreign');
			$table->integer('category_id')->unsigned()->index('question_categories_category_id_foreign');
			$table->string('question', 500);
			$table->enum('answer_method', array('dateT','textBox','dropDown','mcq','rating','3Combo'))->comment('dateT - Date Time, textBox - text Type, dropDown - drop down Type , mcq - Multiple choice Question, 3Combo - combination of 2 dropbox and textbox');
			$table->text('narrative_output', 65535)->nullable();
			$table->enum('clinical_question', array('0','1'))->default('0')->comment('1 - Yes , 0 - No');
			$table->integer('master_question_id')->nullable();
			$table->char('allow_multiple_answer', 1)->default('N');
			$table->text('comments', 65535)->nullable();
			$table->enum('quest_status', array('1','0'))->default('1')->comment('1 - Enabled, 0 - Disabled');
			$table->char('created_via', 2)->default('N')->comment('N - Normal Create, C - copy question, CN - copied question but currently Nomal as it displayed once as copied.');
			$table->enum('active', array('Y','N'))->default('Y')->comment('N - In active,Y - Active');
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
		Schema::drop('question_categories');
	}

}
