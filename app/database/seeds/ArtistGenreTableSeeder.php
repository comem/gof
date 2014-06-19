<?php

class ArtistGenreTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('artist_genre')->delete();

		// hard metal
		ArtistGenre::create(array(
				'artist_id' => 1,
				'genre_id' => 1
			));
	}
}