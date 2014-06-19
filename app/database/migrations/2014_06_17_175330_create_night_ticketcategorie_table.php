<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNightTicketcategorieTable extends Migration {

	public function up()
	{
		Schema::create('night_ticketcategorie', function(Blueprint $table) {
			$table->integer('ticketcategorie_id')->unsigned();
			$table->integer('night_id')->unsigned();
			$table->integer('amount');
			$table->integer('quantity_sold')->nullable();
			$table->string('comment_de')->nullable();
			$table->primary(array('ticketcategorie_id', 'night_id'));
		});
	}

	public function down()
	{
		Schema::drop('night_ticketcategorie');
	}
}