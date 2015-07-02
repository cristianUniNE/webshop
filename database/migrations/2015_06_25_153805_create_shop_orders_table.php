<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_orders', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('user_id');
            $table->integer('coupon_id')->nullable();
            $table->integer('shipping_id');
            $table->integer('amount');
            $table->string('order_no');
            $table->string('onetimeurl')->nullable(); // For download items
            $table->softDeletes();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('shop_orders');
	}

}
