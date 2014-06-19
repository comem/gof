<?php

class GenreTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('genres')->delete();

		// hard metal
		Genre::create(array(
				'name_de' => 'hard metal'
			));
	}
}