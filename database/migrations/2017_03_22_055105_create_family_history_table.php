<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFamilyHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('family_history', function(Blueprint $table)
		{
			$table->integer('id')->unsigned()->primary();
			$table->integer('patient_id')->unsigned();
			$table->string('illness')->nullable();
			$table->string('relation')->nullable();
			$table->dateTime('illness_date');
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
		Schema::drop('family_history');
	}

}
