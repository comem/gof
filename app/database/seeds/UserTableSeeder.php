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
				'password' => '$2y$10$wNSfYSxvd6RqYAqWaSkEIeFgA/C1yR4vAWfG.qSlVyQLpmXDhCJt2',
				'group_id' => 1,
				'language_id' => 1
			));

		// cedric
		User::create(array(
				'email' => 'cedric.liengme@heig-vd.ch',
				'first_name' => 'cedric',
				'last_name' => 'liengme',
				'password' => '$2y$10$wNSfYSxvd6RqYAqWaSkEIeFgA/C1yR4vAWfG.qSlVyQLpmXDhCJt2',
				'group_id' => 1,
				'language_id' => 1
			));
                // emmanuel
		User::create(array(
				'email' => 'emmanuel.bezencon@heig-vd.ch',
				'first_name' => 'emmanuel',
				'last_name' => 'bezencon',
				'password' => '$2y$10$wNSfYSxvd6RqYAqWaSkEIeFgA/C1yR4vAWfG.qSlVyQLpmXDhCJt2',
				'group_id' => 1,
				'language_id' => 1
			));
                 // staff
		User::create(array(
				'email' => 'staff',
				'first_name' => 'staff',
				'last_name' => 'staff',
				'password' => '$2y$10$wNSfYSxvd6RqYAqWaSkEIeFgA/C1yR4vAWfG.qSlVyQLpmXDhCJt2',
				'group_id' => 2,
				'language_id' => 1
			));
                // admin
		User::create(array(
				'email' => 'admin',
				'first_name' => 'admin',
				'last_name' => 'admin',
				'password' => '$2y$10$wNSfYSxvd6RqYAqWaSkEIeFgA/C1yR4vAWfG.qSlVyQLpmXDhCJt2',
				'group_id' => 1,
				'language_id' => 1
			));
	}
}