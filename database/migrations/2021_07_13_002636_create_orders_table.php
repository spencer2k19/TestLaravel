<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('total')->nullable(false);
            $table->foreign('user_id')->on('users')
                ->references('id')
                ->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('order_product',function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('total')->nullable(false);
            $table->unsignedBigInteger('quantity')->nullable(false)->default(1);
            $table->unsignedBigInteger('order_id')->nullable(false);
            $table->foreign('order_id')->on('orders')
                ->references('id')
                ->onDelete('restrict');
            $table->unsignedBigInteger('product_id')->nullable(false);
            $table->foreign('product_id')
                ->on('products')
                ->references('id')
                ->onDelete('restrict');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_product');
        Schema::dropIfExists('orders');
    }
}
