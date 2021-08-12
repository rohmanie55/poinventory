<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTackingoutDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tackingout_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tacking_id');
            $table->unsignedBigInteger('barang_id');
            $table->integer('qty_brg');
            $table->foreign('barang_id')->references('id')->on('goods')->onDelete('restrict');
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
        Schema::dropIfExists('tackingout_details');
    }
}
