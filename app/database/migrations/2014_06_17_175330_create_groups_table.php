<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGroupsTable extends Migration {

	public function up()
	{
		Schema::create('groups', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name')->unique();
			$table->timestamps();
			$table->integer('iheritance')->nullable()->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('groups');
	}
}