<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJobsTable extends Migration {

	public function up()
	{
		Schema::create('jobs', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name_de')->unique();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('jobs');
	}
}