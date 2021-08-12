<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTackingoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tackingouts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_tacking', 50);
            $table->date('tgl_tacking');
            $table->string('tujuan');
            $table->string('lokasi');
            $table->string('receiveby');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
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
        Schema::dropIfExists('tackingouts');
    }
}
