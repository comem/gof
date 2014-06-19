<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGiftNightTable extends Migration {

	public function up()
	{
		Schema::create('gift_night', function(Blueprint $table) {
			$table->integer('night_id')->unsigned();
			$table->integer('gift_id')->unsigned();
			$table->integer('quantity');
			$table->integer('cost')->nullable();
			$table->text('comment_de')->nullable();
			$table->primary(array('night_id', 'gift_id'));
		});
	}

	public function down()
	{
		Schema::drop('gift_night');
	}
}