<?php

class LinkTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('links')->delete();

		// google
		Link::create(array(
				'url' => 'www.google.ch/gangoffour',
				'name_de' => 'Lien de malade',
				'title_de' => 'Titre du lien de malade',
				'artist_id' => 1
			));
	}
}