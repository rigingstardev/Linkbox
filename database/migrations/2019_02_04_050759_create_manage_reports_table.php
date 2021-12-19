<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManageReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manage_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id');
            $table->integer('physician_id');
            $table->integer('question_set_id');
            $table->integer('question_recipients_id');
            $table->integer('send_to_id');
            $table->enum('report_type', array('S','E'))->comment('S - Summary report, E - evaluation reports');
            $table->text('report');
            $table->string('pdf_file', 255)->nullable();
            $table->integer('notification_id')->nullable();
            $table->char('status', 1)->default('P')->comment('P - Pending, A- Approved, D - Declined');
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
        Schema::dropIfExists('manage_reports');
    }
}
