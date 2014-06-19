<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateResourcesTable extends Migration {

	public function up()
	{
		Schema::create('resources', function(Blueprint $table) {
			$table->increments('id');
			$table->string('model');
			$table->string('function');
			$table->timestamps();
			$table->unique(array('model', 'function'));
		});
	}

	public function down()
	{
		Schema::drop('resources');
	}
}