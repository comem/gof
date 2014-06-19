<?php

class NightTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('nights')->delete();

		// event_1
		Night::create(array(
				'start_date_hour' => '1998-01-02 01:01:01.000001',
				'ending_date_hour' => '1998-01-02 01:01:01.000002',
				'title_de' => 'event de la mort',
				'nb_meal' => 34,
				'nb_vegans_meal' => 32,
				'meal_notes' => 'Un vegans est dans la place !',
				'nb_places' => 200,
				'contact_src' => 'javier.txt',
				'notes' => 'c est trop bien',
				'nighttype_id' => 1,
				'image_id' => 1
			));
	}
}