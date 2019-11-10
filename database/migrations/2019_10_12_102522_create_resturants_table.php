<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateResturantsTable extends Migration {

	public function up()
	{
		Schema::create('resturants', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('email');
			$table->string('phone');
			$table->string('password');
			$table->integer('neighborhood_id')->unsigned()->nullable();
			$table->double('delivery_fees');
			$table->double('minimum');
			$table->string('contact_phone');
			$table->string('whats_app');
			$table->integer('category_id')->unsigned()->nullable();
			$table->string('image');
			$table->boolean('status');
		});
	}

	public function down()
	{
		Schema::drop('resturants');
	}
}