<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryDefaultOptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('category_default_options', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('question_id')->unsigned()->index('category_default_options_category_id_foreign');
			$table->string('default_option');
			$table->char('active', 1)->default('Y');
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
		Schema::drop('category_default_options');
	}

}
