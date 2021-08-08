<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_order', 100)->unique();
            $table->date('tgl_order');
            $table->double('total');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('suplier_id');
            $table->unsignedBigInteger('kanban_id');
            $table->unsignedBigInteger('approve_id')->nullable();
            $table->timestamp('approve_at')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('suplier_id')->references('id')->on('suppliers')->onDelete('restrict');
            $table->foreign('kanban_id')->references('id')->on('kanbans')->onDelete('restrict');
            $table->foreign('approve_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
