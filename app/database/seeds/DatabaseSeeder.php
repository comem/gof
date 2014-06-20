<?php

class DatabaseSeeder extends Seeder {

	public function run()
	{
		Eloquent::unguard();
                
                $this->call('NighttypesTableSeeder');
		$this->command->info('nighttypes table seeded!');
                
                $this->call('InstrumentTableSeeder');
		$this->command->info('Instrument table seeded!');
                
                $this->call('PlatformTableSeeder');
		$this->command->info('Platform table seeded!');
                
                $this->call('GenreTableSeeder');
		$this->command->info('Genre table seeded!');
                
                $this->call('MusicianTableSeeder');
		$this->command->info('Musician table seeded!');
                
                $this->call('ArtistTableSeeder');
		$this->command->info('Artist table seeded!');
                
                $this->call('LinkTableSeeder');
		$this->command->info('Link table seeded!');
                
                $this->call('ImageTableSeeder');
		$this->command->info('Image table seeded!');

                
                $this->call('TicketcategorieTableSeeder');
		$this->command->info('Ticketcategorie table seeded!');
                
                $this->call('ArtistMusicianTableSeeder');
		$this->command->info('ArtistMusician table seeded!');

		$this->call('NightTableSeeder');
		$this->command->info('Night table seeded!');

		



		

		$this->call('NightTicketcategorieTableSeeder');
		$this->command->info('NightTicketcategorie table seeded!');



		




		$this->call('ArtistGenreTableSeeder');
		$this->command->info('ArtistGenre table seeded!');

		$this->call('ArtistNightTableSeeder');
		$this->command->info('ArtistNight table seeded!');
                
                $this->call('LanguageTableSeeder');
		$this->command->info('LanguageTableSeeder table seeded!');
                $this->call('GroupTableSeeder');
		$this->command->info('GroupTableSeeder table seeded!');
                $this->call('UserTableSeeder');
		$this->command->info('UserTableSeeder table seeded!');
                $this->call('ResourceTableSeeder');
		$this->command->info('ResourceTableSeeder table seeded!');
                $this->call('GroupResourceTableSeeder');
		$this->command->info('GroupResourceTableSeeder table seeded!');






	}
}