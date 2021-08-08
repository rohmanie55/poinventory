<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKanbanDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kanban_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kanban_id');
            $table->unsignedBigInteger('barang_id');
            $table->integer('qty_request');
            $table->string('status', 50);
            $table->foreign('kanban_id')->references('id')->on('kanbans')->onDelete('cascade');
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
        Schema::dropIfExists('kanban_details');
    }
}
