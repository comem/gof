<?php

class PlatformTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('platforms')->delete();

		// facebook
		Platform::create(array(
				'name' => 'facebook',
				'client_id' => '633123843450489',
				'client_secret' => '91a52c205a79953f5e610e49aa43abcb',
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