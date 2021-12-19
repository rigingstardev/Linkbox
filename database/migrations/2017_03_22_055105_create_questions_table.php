<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('questions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index('questions_user_id_foreign');
			$table->string('title', 100);
			$table->text('description', 65535);
			$table->enum('visibility', array('public','private'))->comment('public - for published question sets, private - for un published');
			$table->char('steps_completed', 1)->default('N');
			$table->enum('is_sponsored', array('N','Y'))->default('N')->comment('N - Not, Y -  Sponsored');
			$table->enum('active', array('Y','N','D'))->default('Y')->comment('Y - active, N - Inactive, D - Disabled');
			$table->string('bg_image')->nullable();
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
		Schema::drop('questions');
	}

}
