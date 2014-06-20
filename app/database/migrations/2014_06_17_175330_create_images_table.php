<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateImagesTable extends Migration {

	public function up()
	{
		Schema::create('images', function(Blueprint $table) {
			$table->increments('id');
			$table->string('caption_de')->nullable();
			$table->string('alt_de')->nullable();
			$table->string('source');
			$table->timestamps();
			$table->integer('artist_id')->unsigned()->nullable();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('images');
	}
}