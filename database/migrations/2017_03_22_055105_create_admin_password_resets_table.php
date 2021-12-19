<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdminPasswordResetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admin_password_resets', function(Blueprint $table)
		{
			$table->string('email')->index();
			$table->string('token')->index();
			// $table->dateTime('created_at')->nullable();
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
		Schema::drop('admin_password_resets');
	}

}
