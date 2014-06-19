<?php

class ArtistTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('artists')->delete();

		// Gang of four
		Artist::create(array(
				'name' => 'Gang of four',
				'short_description_de' => 'Petite description',
				'complete_description_de' => 'Grande description'
			));
	}
}