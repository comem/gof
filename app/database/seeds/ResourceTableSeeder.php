<?php

class ResourceTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('resources')->delete();

		// instrument
		Resource::create(array(
				'model' => 'InstrumentsController',
				'function' => 'VIEW'
			));
                
                 Resource::create(array(
				'model' => 'NightTicketcategorieController',
				'function' => 'VIEW'
			));
                Resource::create(array(
				'model' => 'ArtistGenreController',
				'function' => 'VIEW'
			));
                Resource::create(array(
				'model' => 'ArtistImageController',
				'function' => 'VIEW'
			));
                Resource::create(array(
				'model' => 'NightImageController',
				'function' => 'VIEW'
			));
                
                 Resource::create(array(
				'model' => 'ImagesController',
				'function' => 'VIEW'
			));
                 
                 Resource::create(array(
				'model' => 'GenresController',
				'function' => 'VIEW'
			));
                   Resource::create(array(
				'model' => 'PlatformsController',
				'function' => 'VIEW'
			));
                Resource::create(array(
				'model' => 'TicketCategoriesController',
				'function' => 'VIEW'
			));
                Resource::create(array(
				'model' => 'EventtypesController',
				'function' => 'VIEW'
			));
                 Resource::create(array(
				'model' => 'ArtistsController',
				'function' => 'VIEW'
			));
                  Resource::create(array(
				'model' => 'NightsController',
				'function' => 'VIEW'
			));
                  Resource::create(array(
				'model' => 'ArtistNightController',
				'function' => 'VIEW'
			));
                Resource::create(array(
				'model' => 'LinksController',
				'function' => 'VIEW'
			));
                Resource::create(array(
				'model' => 'ArtistNightController',
				'function' => 'SAVE'
			));
                 Resource::create(array(
				'model' => 'ArtistMusicianController',
				'function' => 'VIEW'
			));
                  Resource::create(array(
				'model' => 'NightPublicationController',
				'function' => 'VIEW'
			));
                   Resource::create(array(
				'model' => 'MusiciansController',
				'function' => 'VIEW'
			));
                
                Resource::create(array(
				'model' => 'InstrumentsController',
				'function' => 'SAVE'
			));
                //Genre
                
                Resource::create(array(
				'model' => 'GenresController',
				'function' => 'SAVE'
			));
               
                Resource::create(array(
				'model' => 'ImagesController',
				'function' => 'SAVE'
			));
                 
               
                Resource::create(array(
				'model' => 'ArtistsController',
				'function' => 'SAVE'
			));
                Resource::create(array(
				'model' => 'ArtistsController',
				'function' => 'MODIFY'
			));
               
                Resource::create(array(
				'model' => 'MusiciansController',
				'function' => 'SAVE'
			));
               
                Resource::create(array(
				'model' => 'NightsController',
				'function' => 'SAVE'
			));
                Resource::create(array(
				'model' => 'NightsController',
				'function' => 'MODIFY'
			));
                Resource::create(array(
				'model' => 'NightsController',
				'function' => 'ERASE'
			));
                
                Resource::create(array(
				'model' => 'LinksController',
				'function' => 'SAVE'
			));
               
                Resource::create(array(
				'model' => 'ArtistMusicianController',
				'function' => 'SAVE'
			));
                Resource::create(array(
				'model' => 'ArtistMusicianController',
				'function' => 'MODIFIY'
			));
                
                Resource::create(array(
				'model' => 'ArtistNightController',
				'function' => 'MODIFY'
			));
                Resource::create(array(
				'model' => 'ArtistNightController',
				'function' => 'ERASE'
			));
               
                Resource::create(array(
				'model' => 'NightPublicationController',
				'function' => 'SAVE'
			));
                Resource::create(array(
				'model' => 'NightPublicationController',
				'function' => 'ERASE'
			));
                Resource::create(array(
				'model' => 'NightPublicationController',
				'function' => 'MODIFY'
			));
               
                Resource::create(array(
				'model' => 'NightTicketcategorieController',
				'function' => 'SAVE'
			));
                Resource::create(array(
				'model' => 'NightTicketcategorieController',
				'function' => 'ERASE'
			));
                Resource::create(array(
				'model' => 'NightTicketcategorieController',
				'function' => 'MODIFY'
			));
                
                Resource::create(array(
				'model' => 'ArtistGenreController',
				'function' => 'SAVE'
			));
                Resource::create(array(
				'model' => 'ArtistGenreController',
				'function' => 'MODIFY'
			));
                
                Resource::create(array(
				'model' => 'ArtistImageController',
				'function' => 'SAVE'
			));
                Resource::create(array(
				'model' => 'ArtistImageController',
				'function' => 'MODIFY'
			));
                
                Resource::create(array(
				'model' => 'NightImageController',
				'function' => 'SAVE'
			));
                Resource::create(array(
				'model' => 'NightImageController',
				'function' => 'MODIFY'
			));
                Resource::create(array(
				'model' => 'NightImageController',
				'function' => 'ERASE'
			));
                
                
                

                



	}
}