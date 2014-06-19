<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEquipmentNightTable extends Migration {

	public function up()
	{
		Schema::create('equipment_night', function(Blueprint $table) {
			$table->integer('night_id')->unsigned();
			$table->integer('equipment_id')->unsigned();
			$table->integer('cost')->nullable();
			$table->integer('quantity')->nullable()->default('1');
			$table->primary(array('night_id', 'equipment_id'));
		});
	}

	public function down()
	{
		Schema::drop('equipment_night');
	}
}