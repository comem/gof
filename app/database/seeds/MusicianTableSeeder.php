<?php

class MusicianTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('musicians')->delete();

		// cédric liengme
		Musician::create(array(
				'first_name' => 'cédric',
				'last_name' => 'liengme',
				'stagename' => 'the killer'
			));

		// florent plomb
		Musician::create(array(
				'first_name' => 'florent',
				'last_name' => 'plomb',
				'stagename' => 'the teletubbies'
			));

		// emmanuel bezencon
		Musician::create(array(
				'first_name' => 'emmanuel',
				'last_name' => 'bezencon',
				'stagename' => 'The Coder'
			));
	}
}