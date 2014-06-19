<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('nights', function(Blueprint $table) {
			$table->foreign('nighttype_id')->references('id')->on('nighttypes')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('nights', function(Blueprint $table) {
			$table->foreign('image_id')->references('id')->on('images')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('night_member', function(Blueprint $table) {
			$table->foreign('night_id')->references('id')->on('nights')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('night_member', function(Blueprint $table) {
			$table->foreign('member_id')->references('id')->on('members')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('night_member', function(Blueprint $table) {
			$table->foreign('job_id')->references('id')->on('jobs')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('images', function(Blueprint $table) {
			$table->foreign('artist_id')->references('id')->on('artists')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('job_night', function(Blueprint $table) {
			$table->foreign('night_id')->references('id')->on('nights')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('job_night', function(Blueprint $table) {
			$table->foreign('job_id')->references('id')->on('jobs')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('night_printingtype', function(Blueprint $table) {
			$table->foreign('printingtype_id')->references('id')->on('printingtypes')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('night_printingtype', function(Blueprint $table) {
			$table->foreign('night_id')->references('id')->on('nights')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('night_ticketcategorie', function(Blueprint $table) {
			$table->foreign('ticketcategorie_id')->references('id')->on('ticketcategories')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('night_ticketcategorie', function(Blueprint $table) {
			$table->foreign('night_id')->references('id')->on('nights')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('artist_musician', function(Blueprint $table) {
			$table->foreign('musician_id')->references('id')->on('musicians')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('artist_musician', function(Blueprint $table) {
			$table->foreign('artist_id')->references('id')->on('artists')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('artist_musician', function(Blueprint $table) {
			$table->foreign('instrument_id')->references('id')->on('instruments')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('artist_genre', function(Blueprint $table) {
			$table->foreign('artist_id')->references('id')->on('artists')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('artist_genre', function(Blueprint $table) {
			$table->foreign('genre_id')->references('id')->on('genres')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('artist_night', function(Blueprint $table) {
			$table->foreign('artist_id')->references('id')->on('artists')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('artist_night', function(Blueprint $table) {
			$table->foreign('night_id')->references('id')->on('nights')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('links', function(Blueprint $table) {
			$table->foreign('artist_id')->references('id')->on('artists')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('members', function(Blueprint $table) {
			$table->foreign('adresse_id')->references('id')->on('adresses')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('job_member', function(Blueprint $table) {
			$table->foreign('member_id')->references('id')->on('members')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('job_member', function(Blueprint $table) {
			$table->foreign('job_id')->references('id')->on('jobs')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('equipment_night', function(Blueprint $table) {
			$table->foreign('night_id')->references('id')->on('nights')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('equipment_night', function(Blueprint $table) {
			$table->foreign('equipment_id')->references('id')->on('equipments')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('gift_night', function(Blueprint $table) {
			$table->foreign('night_id')->references('id')->on('nights')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('gift_night', function(Blueprint $table) {
			$table->foreign('gift_id')->references('id')->on('gifts')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('night_plateform', function(Blueprint $table) {
			$table->foreign('plateform_id')->references('id')->on('plateforms')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('night_plateform', function(Blueprint $table) {
			$table->foreign('night_id')->references('id')->on('nights')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('users', function(Blueprint $table) {
			$table->foreign('group_id')->references('id')->on('groups')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('users', function(Blueprint $table) {
			$table->foreign('language_id')->references('id')->on('languages')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('groups', function(Blueprint $table) {
			$table->foreign('iheritance')->references('id')->on('groups')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('group_resource', function(Blueprint $table) {
			$table->foreign('group_id')->references('id')->on('groups')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('group_resource', function(Blueprint $table) {
			$table->foreign('resource_id')->references('id')->on('resources')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('nights', function(Blueprint $table) {
			$table->dropForeign('nights_nighttype_id_foreign');
		});
		Schema::table('nights', function(Blueprint $table) {
			$table->dropForeign('nights_image_id_foreign');
		});
		Schema::table('night_member', function(Blueprint $table) {
			$table->dropForeign('night_member_night_id_foreign');
		});
		Schema::table('night_member', function(Blueprint $table) {
			$table->dropForeign('night_member_member_id_foreign');
		});
		Schema::table('night_member', function(Blueprint $table) {
			$table->dropForeign('night_member_job_id_foreign');
		});
		Schema::table('images', function(Blueprint $table) {
			$table->dropForeign('images_artist_id_foreign');
		});
		Schema::table('job_night', function(Blueprint $table) {
			$table->dropForeign('job_night_night_id_foreign');
		});
		Schema::table('job_night', function(Blueprint $table) {
			$table->dropForeign('job_night_job_id_foreign');
		});
		Schema::table('night_printingtype', function(Blueprint $table) {
			$table->dropForeign('night_printingtype_printingtype_id_foreign');
		});
		Schema::table('night_printingtype', function(Blueprint $table) {
			$table->dropForeign('night_printingtype_night_id_foreign');
		});
		Schema::table('night_ticketcategorie', function(Blueprint $table) {
			$table->dropForeign('night_ticketcategorie_ticketcategorie_id_foreign');
		});
		Schema::table('night_ticketcategorie', function(Blueprint $table) {
			$table->dropForeign('night_ticketcategorie_night_id_foreign');
		});
		Schema::table('artist_musician', function(Blueprint $table) {
			$table->dropForeign('artist_musician_musician_id_foreign');
		});
		Schema::table('artist_musician', function(Blueprint $table) {
			$table->dropForeign('artist_musician_artist_id_foreign');
		});
		Schema::table('artist_musician', function(Blueprint $table) {
			$table->dropForeign('artist_musician_instrument_id_foreign');
		});
		Schema::table('artist_genre', function(Blueprint $table) {
			$table->dropForeign('artist_genre_artist_id_foreign');
		});
		Schema::table('artist_genre', function(Blueprint $table) {
			$table->dropForeign('artist_genre_genre_id_foreign');
		});
		Schema::table('artist_night', function(Blueprint $table) {
			$table->dropForeign('artist_night_artist_id_foreign');
		});
		Schema::table('artist_night', function(Blueprint $table) {
			$table->dropForeign('artist_night_night_id_foreign');
		});
		Schema::table('links', function(Blueprint $table) {
			$table->dropForeign('links_artist_id_foreign');
		});
		Schema::table('members', function(Blueprint $table) {
			$table->dropForeign('members_adresse_id_foreign');
		});
		Schema::table('job_member', function(Blueprint $table) {
			$table->dropForeign('job_member_member_id_foreign');
		});
		Schema::table('job_member', function(Blueprint $table) {
			$table->dropForeign('job_member_job_id_foreign');
		});
		Schema::table('equipment_night', function(Blueprint $table) {
			$table->dropForeign('equipment_night_night_id_foreign');
		});
		Schema::table('equipment_night', function(Blueprint $table) {
			$table->dropForeign('equipment_night_equipment_id_foreign');
		});
		Schema::table('gift_night', function(Blueprint $table) {
			$table->dropForeign('gift_night_night_id_foreign');
		});
		Schema::table('gift_night', function(Blueprint $table) {
			$table->dropForeign('gift_night_gift_id_foreign');
		});
		Schema::table('night_plateform', function(Blueprint $table) {
			$table->dropForeign('night_plateform_plateform_id_foreign');
		});
		Schema::table('night_plateform', function(Blueprint $table) {
			$table->dropForeign('night_plateform_night_id_foreign');
		});
		Schema::table('users', function(Blueprint $table) {
			$table->dropForeign('users_group_id_foreign');
		});
		Schema::table('users', function(Blueprint $table) {
			$table->dropForeign('users_language_id_foreign');
		});
		Schema::table('groups', function(Blueprint $table) {
			$table->dropForeign('groups_iheritance_foreign');
		});
		Schema::table('group_resource', function(Blueprint $table) {
			$table->dropForeign('group_resource_group_id_foreign');
		});
		Schema::table('group_resource', function(Blueprint $table) {
			$table->dropForeign('group_resource_resource_id_foreign');
		});
	}
}