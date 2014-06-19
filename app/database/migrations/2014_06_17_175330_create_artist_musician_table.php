<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArtistMusicianTable extends Migration {

	public function up()
	{
		Schema::create('artist_musician', function(Blueprint $table) {
			$table->integer('musician_id')->unsigned();
			$table->integer('artist_id')->unsigned();
			$table->integer('instrument_id')->unsigned();
			$table->softDeletes();
			$table->primary(array('musician_id', 'artist_id', 'instrument_id'));
		});
	}

	public function down()
	{
		Schema::drop('artist_musician');
	}
}