<?php

class NighttypesTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('nighttypes')->delete();

		// spectacle de danse
		Nighttype::create(array(
				'name_de' => 'spectacle de danse'
			));
	}
}