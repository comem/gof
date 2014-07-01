<?php

class TicketcategorieTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('ticketcategories')->delete();

		// enfant/avs
		Ticketcategorie::create(array(
				'name_de' => 'enfant-avs'
			));

		// adulte
		Ticketcategorie::create(array(
				'name_de' => 'adulte'
			));
	}
}