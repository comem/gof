<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArtistNightTable extends Migration {

	public function up()
	{
		Schema::create('artist_night', function(Blueprint $table) {
			$table->integer('artist_id')->unsigned();
			$table->integer('night_id')->unsigned();
			$table->integer('order');
			$table->boolean('is_support');
			$table->datetime('artist_hour_arrival');
			$table->primary(array('artist_id', 'night_id', 'order'));
		});
	}

	public function down()
	{
		Schema::drop('artist_night');
	}
}