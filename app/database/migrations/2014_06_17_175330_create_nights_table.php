<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNightsTable extends Migration {

	public function up()
	{
		Schema::create('nights', function(Blueprint $table) {
			$table->increments('id');
			$table->datetime('start_date_hour')->unique();
			$table->datetime('ending_date_hour');
			$table->datetime('opening_doors')->nullable();
			$table->string('title_de');
			$table->integer('nb_meal');
			$table->integer('nb_vegans_meal');
			$table->text('meal_notes')->nullable();
			$table->integer('nb_places')->nullable()->default('180');
			$table->boolean('followed_by_private');
			$table->string('contact_src')->nullable();
			$table->text('notes')->nullable();
			$table->datetime('published_at')->nullable();
			$table->integer('nighttype_id')->unsigned();
			$table->integer('image_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('nights');
	}
}