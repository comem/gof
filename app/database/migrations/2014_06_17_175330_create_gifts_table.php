<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGiftsTable extends Migration {

	public function up()
	{
		Schema::create('gifts', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name_de')->unique();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('gifts');
	}
}