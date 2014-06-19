<?php

class PlateformTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('plateforms')->delete();

		// facebook
		Plateform::create(array(
				'name' => 'facebook',
				'client_id' => 'client_id',
				'client_secret' => 'client_secret',
				'api_infos' => 'api_infos'
			));

		// twitter
		Plateform::create(array(
				'name' => 'twitter',
				'client_id' => 'client_id',
				'client_secret' => 'client_secret',
				'api_infos' => 'twitter_infos'
			));
	}
}