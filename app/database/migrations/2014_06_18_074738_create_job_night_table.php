<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJobNightTable extends Migration {

	public function up()
	{
		Schema::create('job_night', function(Blueprint $table) {
			$table->integer('night_id')->unsigned();
			$table->integer('job_id')->unsigned();
			$table->integer('nb_people');
                        $table->primary(array('night_id', 'job_id'));
		});
	}

	public function down()
	{
		Schema::drop('job_night');
	}
}