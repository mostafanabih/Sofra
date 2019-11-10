<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOffersTable extends Migration {

	public function up()
	{
		Schema::create('offers', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('image');
			$table->string('description');
			$table->date('date_from');
			$table->date('date_to');
			$table->integer('resturant_id')->unsigned()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('offers');
	}
}