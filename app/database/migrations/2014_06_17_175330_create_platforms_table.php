<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlatformsTable extends Migration {

	public function up()
	{
		Schema::create('platforms', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name')->unique();
			$table->string('client_id')->nullable();
			$table->string('client_secret')->nullable();
			$table->text('api_infos')->nullable();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('platforms');
	}
}