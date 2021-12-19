<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePatientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('patients', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('email')->unique();
			$table->string('password');
			$table->enum('gender', array('F','M','-'))->default('F')->comment(' F - Female, M - Male, - if the registration pending');
			$table->date('dob')->nullable();
			$table->string('nationality', 100)->nullable();
			$table->string('activation_code')->nullable();
			$table->string('social_status', 500)->nullable();
			$table->string('contact_number', 100)->nullable();
			$table->string('profile_image', 100)->nullable();
			$table->enum('is_account_active', array('N','Y','P'))->default('N')->comment('N - In active,Y - Active, P - Pending');
			$table->smallInteger('isLocked');
			$table->char('left_menu_display_type', 1)->default(0)->comment('0 - Expanded Menu,1 - Collapsed Menu');
			$table->string('remember_token', 100)->nullable();
			$table->enum('entry_type', array('R','E','T'))->default('R')->comment('R - Normal Registeration, E - via Email, T - via Text/SMS');
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
		Schema::drop('patients');
	}

}
