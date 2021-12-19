<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifications', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('question_id');
			$table->char('notification_type', 1)->default(1)->comment('1 - Clinical (Physician), 2 - Administrative  (Physician), 3 - Notifications (Patients), 4, Approvals( (Patients)');
			$table->char('is_seen', 1)->default(0)->comment(' 0 - Not seen or Read, 1 Seen/Read');
			$table->string('message', 500);
			$table->integer('sender_id')->unsigned()->index('notifications_sender_id_foreign');
			$table->enum('sender_type', array('1','2','3'))->default('2')->comment('1 - Admin, 2 - Physician, 3 - Patient');
			$table->integer('receiver_id')->unsigned()->index('notifications_receiver_id_foreign')->comment('Can patient Id if notification_type other than 4, or physician id if the notification_type= 4');
			$table->integer('receiver_type')->default(1)->comment('1 - Physician, 2 - Patient');
			$table->integer('send_report_to')->default(0)->comment('0  if not application, others - primary key of users table');
			$table->integer('question_recipients_id')->comment('Primary key of question_recipients');
			$table->char('status', 1)->nullable()->default('N')->comment('N - Not applicable, A - Approved, P -- Pending, D - Declined');
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
		Schema::drop('notifications');
	}

}
