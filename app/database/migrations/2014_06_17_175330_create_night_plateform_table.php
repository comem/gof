<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNightPlateformTable extends Migration {

	public function up()
	{
		Schema::create('night_plateform', function(Blueprint $table) {
			$table->integer('plateform_id')->unsigned();
			$table->integer('night_id')->unsigned();
			$table->string('external_id');
			$table->text('external_infos')->nullable();
			$table->string('url');
			$table->timestamps();
			$table->softDeletes();
			$table->primary(array('plateform_id', 'night_id'));
		});
	}

	public function down()
	{
		Schema::drop('night_plateform');
	}
}