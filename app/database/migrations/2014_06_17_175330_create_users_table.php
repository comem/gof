<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('email')->unique();
			$table->string('first_name');
			$table->string('last_name');
			$table->string('password');
			$table->datetime('last_login')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('group_id')->unsigned();
			$table->integer('language_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('users');
	}
}