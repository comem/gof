<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePrintingtypesTable extends Migration {

	public function up()
	{
		Schema::create('printingtypes', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name_de');
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('printingtypes');
	}
}