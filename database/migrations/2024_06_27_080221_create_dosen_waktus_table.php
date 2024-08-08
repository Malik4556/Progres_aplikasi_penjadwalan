<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen_waktus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dosen_id');
            $table->foreign('dosen_id')->references('id')->on('dosens')->onDelete('restrict');
            $table->unsignedBigInteger('hari_id');
            $table->foreign('hari_id')->references('id')->on('haris')->onDelete('restrict');
            $table->unsignedBigInteger('jam_id');
            $table->foreign('jam_id')->references('id')->on('jams')->onDelete('restrict');
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
        Schema::dropIfExists('dosen_waktus');
    }
};
