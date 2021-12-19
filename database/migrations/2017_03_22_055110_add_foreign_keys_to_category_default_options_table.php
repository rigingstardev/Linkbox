<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCategoryDefaultOptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('category_default_options', function(Blueprint $table)
		{
			$table->foreign('question_id', 'category_default_options_category_id_foreign')->references('id')->on('categories')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('category_default_options', function(Blueprint $table)
		{
			$table->dropForeign('category_default_options_category_id_foreign');
		});
	}

}
