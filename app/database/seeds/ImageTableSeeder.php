<?php

class ImageTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('images')->delete();

		// artist_description_image
		Image::create(array(
				'caption_de' => 'artist_description_image',
				'alt_de' => 'artist_description_image',
				'source' => 'img/images/image.jpg',
				'artist_id' => 1
			));
	}
}