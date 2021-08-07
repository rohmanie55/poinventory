<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('barang_id');
            $table->unsignedBigInteger('kanban_det_id');
            $table->integer('qty_order');
            $table->double('subtotal');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('restrict');
            $table->foreign('kanban_det_id')->references('id')->on('kanban_details')->onDelete('restrict');
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
        Schema::dropIfExists('order_details');
    }
}
