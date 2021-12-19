<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSurgicalHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('surgical_history', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('patient_id')->unsigned()->index('surgical_history_patient_medical_report_id_foreign');
			$table->string('surgery');
			$table->dateTime('surgery_date');
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
		Schema::drop('surgical_history');
	}

}
