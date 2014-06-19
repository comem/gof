<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJobMemberTable extends Migration {

	public function up()
	{
		Schema::create('job_member', function(Blueprint $table) {
			$table->integer('member_id')->unsigned();
			$table->integer('job_id')->unsigned();
                        $table->primary(array('member_id', 'job_id'));
		});
	}

	public function down()
	{
		Schema::drop('job_member');
	}
}