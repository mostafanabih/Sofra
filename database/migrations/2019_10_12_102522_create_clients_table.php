<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->string('name');
			$table->increments('id');
			$table->timestamps();
			$table->string('email');
			$table->string('phone');
			$table->string('password');
			$table->integer('city_id')->unsigned()->nullable();
			$table->integer('neighborhood_id')->unsigned()->nullable();
			$table->string('api_token');
			$table->string('image');
		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}