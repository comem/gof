<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMembersTable extends Migration {

	public function up()
	{
		Schema::create('members', function(Blueprint $table) {
			$table->increments('id');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('email')->nullable();
			$table->string('phone')->nullable();
			$table->boolean('is_active');
			$table->timestamps();
			$table->integer('adresse_id')->unsigned();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('members');
	}
}