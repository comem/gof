<?php

class NightTicketcategorieTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('night_ticketcategorie')->delete();

		// adult ticket
		NightTicketcategorie::create(array(
				'ticketcategorie_id' => 1,
				'night_id' => 1,
				'amount' => 30
			));

		// kid ticket
		NightTicketcategorie::create(array(
				'ticketcategorie_id' => 2,
				'night_id' => 1,
				'amount' => 455
			));
	}
}