<?php

class GroupTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('groups')->delete();

		// admin
		Group::create(array(
				'name' => 'admin'
			));

		// user
		Group::create(array(
				'name' => 'staff'
			));
	}
}