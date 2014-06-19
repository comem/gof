<?php

class InstrumentTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('instruments')->delete();

		// guitare électrique
		Instrument::create(array(
				'name_de' => 'guitare électrique'
			));

		// batterie
		Instrument::create(array(
				'name_de' => 'batterie'
			));

		// piano
		Instrument::create(array(
				'name_de' => 'piano'
			));
	}
}