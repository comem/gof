<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNightMemberTable extends Migration {

	public function up()
	{
		Schema::create('night_member', function(Blueprint $table) {
			$table->integer('night_id')->unsigned();
			$table->integer('member_id')->unsigned();
			$table->integer('job_id')->unsigned();
                        $table->primary(array('night_id', 'member_id'));
                        
		});
	}

	public function down()
	{
		Schema::drop('night_member');
	}
}