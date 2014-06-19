<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArtistGenreTable extends Migration {

	public function up()
	{
		Schema::create('artist_genre', function(Blueprint $table) {
			$table->integer('artist_id')->unsigned();
			$table->integer('genre_id')->unsigned();
			$table->primary(array('artist_id', 'genre_id'));
		});
	}

	public function down()
	{
		Schema::drop('artist_genre');
	}
}