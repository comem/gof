<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdressesTable extends Migration {

	public function up()
	{
		Schema::create('adresses', function(Blueprint $table) {
			$table->increments('id');
			$table->string('street');
			$table->string('npa');
			$table->string('city');
			$table->string('country')->nullable();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('adresses');
	}
}