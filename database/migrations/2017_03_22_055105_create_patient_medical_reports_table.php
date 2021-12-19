<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePatientMedicalReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('patient_medical_reports', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('patient_id')->unsigned()->index('patient_medical_reports_patient_id_foreign');
			$table->enum('social_smoke', array('0','1'))->comment(' 0 - No Smoking, 1 Yes Smoking');
			$table->enum('social_alcohol', array('0','1'))->comment(' 0 - No Smoking, 1 Yes Smoking');
			$table->enum('social_drug', array('0','1'))->comment(' 0 - No Smoking, 1 Yes Smoking');
			$table->string('social_comments', 500)->comment(' 0 - No Smoking, 1 Yes Smoking');
			$table->string('allergy_comments', 500);
			$table->text('description', 65535);
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
		Schema::drop('patient_medical_reports');
	}

}
