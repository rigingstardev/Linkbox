<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePastMedicalHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('past_medical_history', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('patient_id');
			$table->string('type')->nullable();
			$table->text('description', 65535)->nullable();
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
		Schema::drop('past_medical_history');
	}

}
