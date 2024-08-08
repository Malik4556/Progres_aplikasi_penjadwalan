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
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dosen_waktu_id');
            $table->foreign('dosen_waktu_id')->references('id')->on('dosen_waktus')->onDelete('restrict');
            $table->unsignedBigInteger('kelas_id');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('restrict');
            $table->integer('semester');
            $table->unsignedBigInteger('dosen_matkul_id');
            $table->foreign('dosen_matkul_id')->references('id')->on('dosen_matkuls')->onDelete('restrict');
            $table->integer('sks');
            $table->string('jam_mulai', 20);
            $table->string('jam_selesai', 20);
            $table->unsignedBigInteger('ruangan_id');
            $table->foreign('ruangan_id')->references('id')->on('ruangans')->onDelete('restrict');
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
        Schema::dropIfExists('jadwals_');
    }
};
