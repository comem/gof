<?php

class UserTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('users')->delete();

		// charly
		User::create(array(
				'email' => 'charles-henri.hayoz@heig-vd.ch',
				'first_name' => 'charly',
				'last_name' => 'hayoz',
				'password' => '1234',
				'group_id' => 1,
				'language_id' => 1
			));

		// cedric
		User::create(array(
				'email' => 'cedric.liengme@heig-vd.ch',
				'first_name' => 'cedric',
				'last_name' => 'liengme',
				'password' => '1234',
				'group_id' => 2,
				'language_id' => 1
			));
	}
}