<?php

class LanguageTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('languages')->delete();

		// french
		Language::create(array(
				'locale' => 'fr_fr',
				'name_de' => 'french'
			));
	}
}