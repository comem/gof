<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNightPlatformTable extends Migration {

	public function up()
	{
		Schema::create('night_platform', function(Blueprint $table) {
			$table->integer('platform_id')->unsigned();
			$table->integer('night_id')->unsigned();
			$table->string('external_id');
			$table->text('external_infos')->nullable();
			$table->string('url');
			$table->timestamps();
			$table->primary(array('platform_id', 'night_id'));
		});
	}

	public function down()
	{
		Schema::drop('night_platform');
	}
}