<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('plans', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('plan_id', 100)->comment('Plans Id from Stripe');
			$table->string('name', 100);
			$table->float('amount');
			$table->string('currency');
			$table->string('period', 10);
			$table->enum('plan_type', array('monthly','yearly','custom'));
			$table->smallInteger('sortorder');
			$table->softDeletes();
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
		Schema::drop('plans');
	}

}
