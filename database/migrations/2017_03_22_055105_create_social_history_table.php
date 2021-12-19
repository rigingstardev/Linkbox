<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSocialHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('social_history', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('patient_id');
			$table->enum('smoke', array('1','0'))->comment('1 - Yes, 0 - No');
			$table->enum('drink', array('1','0'))->comment('1 - Yes, 0 - No');
			$table->enum('drug', array('1','0'))->comment('1 - Yes, 0 - No');
			$table->text('comments', 65535)->nullable();
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
		Schema::drop('social_history');
	}

}
