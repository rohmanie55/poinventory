<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('trx_id');
            $table->unsignedBigInteger('barang_id');
            $table->unsignedBigInteger('kanban_det_id');
            $table->integer('qty_brg');
            $table->string('note')->nullable();
            $table->foreign('trx_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->foreign('barang_id')->references('id')->on('goods')->onDelete('restrict');
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
        Schema::dropIfExists('transaction_details');
    }
}
