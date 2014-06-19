<?php

class ArtistNightTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('artist_night')->delete();

		// artist_1
		ArtistNight::create(array(
				'artist_id' => 1,
				'night_id' => 1,
				'order' => 1,
				'is_support' => false,
				'artist_hour_arrival' => '1998-01-02 01:01:01.000001'
			));
	}
}