<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMusiciansTable extends Migration {

	public function up()
	{
		Schema::create('musicians', function(Blueprint $table) {
			$table->increments('id');
			$table->string('first_name');
			$table->string('last_name')->nullable();
			$table->string('stagename')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('musicians');
	}
}