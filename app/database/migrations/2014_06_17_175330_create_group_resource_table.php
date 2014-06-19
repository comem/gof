<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGroupResourceTable extends Migration {

	public function up()
	{
		Schema::create('group_resource', function(Blueprint $table) {
			$table->integer('group_id')->unsigned();
			$table->integer('resource_id')->unsigned();
			$table->primary(array('group_id', 'resource_id'));
		});
	}

	public function down()
	{
		Schema::drop('group_resource');
	}
}