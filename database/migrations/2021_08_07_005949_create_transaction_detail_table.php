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
            $table->unsignedBigInteger('incoming_id');
            $table->unsignedBigInteger('barang_id');
            $table->unsignedBigInteger('kanban_det_id');
            $table->integer('qty_brg');
            $table->string('note')->nullable();
            $table->foreign('incoming_id')->references('id')->on('transaction')->onDelete('cascade');
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
        Schema::dropIfExists('transaction_details');
    }
}
