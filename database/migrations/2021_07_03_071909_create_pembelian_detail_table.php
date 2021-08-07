<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('beli_id');
            $table->unsignedBigInteger('barang_id');
            $table->unsignedBigInteger('order_det_id');
            $table->integer('qty_brg');
            $table->double('subtotal');
            $table->foreign('beli_id')->references('id')->on('pembelians')->onDelete('cascade');
            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('restrict');
            $table->foreign('order_det_id')->references('id')->on('order_details')->onDelete('restrict');
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
        Schema::dropIfExists('pembelian_details');
    }
}
