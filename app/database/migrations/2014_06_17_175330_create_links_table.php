<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLinksTable extends Migration {

	public function up()
	{
		Schema::create('links', function(Blueprint $table) {
			$table->increments('id');
			$table->string('url')->unique();
			$table->string('name_de');
			$table->string('title_de')->nullable();
			$table->integer('artist_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('links');
	}
}