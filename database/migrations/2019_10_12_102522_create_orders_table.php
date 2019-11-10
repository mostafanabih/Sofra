<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('amount');
			$table->string('special_order');
			$table->string('notes');
			$table->double('total_price');
			$table->integer('client_id')->unsigned()->nullable();
			$table->integer('resturant_id')->unsigned()->nullable();
			$table->enum('status', array('pending', 'accepted', 'rejected', 'declined', 'deliverd'));
			$table->enum('payment_method', array('online', 'cash'));
			$table->double('commissin');
			$table->double('cost');
			$table->double('net');
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}