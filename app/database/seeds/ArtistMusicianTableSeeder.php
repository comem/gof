<?php

class ArtistMusicianTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('artist_musician')->delete();

		// florent
		ArtistMusician::create(array(
				'musician_id' => 1,
				'artist_id' => 1,
				'instrument_id' => 1
			));

		// manu
		ArtistMusician::create(array(
				'musician_id' => 2,
				'artist_id' => 1,
				'instrument_id' => 2
			));

		// cedric
		ArtistMusician::create(array(
				'musician_id' => 3,
				'artist_id' => 1,
				'instrument_id' => 3
			));
	}
}