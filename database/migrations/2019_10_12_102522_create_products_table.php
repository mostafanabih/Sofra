<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('ingredients');
			$table->double('price');
			$table->string('image');
			$table->double('price_on_offer');
			$table->time('order_process_time');
			$table->integer('resturant_id')->unsigned()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('products');
	}
}