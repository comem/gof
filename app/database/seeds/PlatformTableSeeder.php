<?php

class PlatformTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('platforms')->delete();

		// facebook
		Platform::create(array(
				'name' => 'facebook',
				'client_id' => 'client_id',
				'client_secret' => 'client_secret',
				'api_infos' => 'api_infos'
			));

		// twitter
		Platform::create(array(
				'name' => 'twitter',
				'client_id' => 'client_id',
				'client_secret' => 'client_secret',
				'api_infos' => 'twitter_infos'
			));
	}
}