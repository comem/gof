<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNightPrintingtypeTable extends Migration {

	public function up()
	{
		Schema::create('night_printingtype', function(Blueprint $table) {
			$table->string('source');
			$table->integer('nb_copies');
			$table->integer('nb_copies_surplus')->nullable();
			$table->integer('printingtype_id')->unsigned();
			$table->integer('night_id')->unsigned();
			$table->primary(array('night_id', 'printingtype_id'));
		});
	}

	public function down()
	{
		Schema::drop('night_printingtype');
	}
}