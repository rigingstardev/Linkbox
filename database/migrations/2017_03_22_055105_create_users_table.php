<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('email');
			$table->integer('speciality_id')->unsigned()->nullable()->index('users_speciality_id_foreign');
			$table->string('hospital_name', 100)->nullable();
			$table->string('npi_number', 100)->nullable();
			$table->string('city', 100)->nullable();
			$table->string('contact_number', 100)->nullable();
			$table->text('profile_description', 65535)->nullable();
			$table->enum('gender', array('M','F'))->nullable()->comment('M - Male, F - Female');
			$table->date('dob')->nullable();
			$table->string('profile_image', 100)->nullable();
			$table->string('password');
			$table->enum('user_role', array('A','D','P','S'))->comment('A - Admin, D - Doctor/Physician, P - Patient,S - Administrative staff');
			$table->string('activation_code')->nullable();
			$table->dateTime('code_expires_at')->nullable();
			$table->enum('is_subscribed', array('N','Y'))->default('N')->comment('N - Not subscribed, Y - Subscribed');
			$table->enum('is_account_active', array('N','Y'))->default('N')->comment('N - In active,Y - Active');
			$table->smallInteger('isLocked');
			$table->char('left_menu_display_type', 1)->default(0)->comment('0 - Expanded Menu,1 - Collapsed Menu');
			$table->string('remember_token', 100)->nullable();
			$table->integer('parent_id')->unsigned()->nullable()->index('users_parent_id_foreign');
			$table->dateTime('last_logged_in');
			$table->boolean('stripe_active')->default(0);
			$table->string('stripe_id')->nullable();
			$table->string('card_brand')->nullable();
			$table->string('card_last_four')->nullable();
			$table->dateTime('trial_ends_at')->nullable();
			$table->dateTime('subscription_ends_at')->nullable();
			$table->string('default_card', 100)->nullable();
			$table->string('doximity_id', 100)->nullable()->unique('doximity_unique');
			$table->unique(['email','user_role']);
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
		Schema::drop('users');
	}

}
