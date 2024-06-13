<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTReservasiBidanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_reservasi_bidan', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->uuid('id', 36)->primary();
            $table->uuid('jadwal_praktek_id', 36);
            $table->integer('no_antrian');
            $table->enum('status', ['Tetap', 'Jadwal Ulang', 'Batal'])->default('Tetap');
            $table->uuid('pasien_id', 36);
            $table->text('keterangan')->nullable();
            $table->uuid('jadwal_praktek_id_lama', 36)->nullable();
            $table->uuid('created_by', 36);
            $table->uuid('updated_by', 36);
            $table->timestamps();
        });

        Schema::table('t_reservasi_bidan', function ($table) {
            $table->foreign('jadwal_praktek_id')->references('id')->on('t_jadwal_praktek');
            $table->foreign('jadwal_praktek_id_lama')->references('id')->on('t_jadwal_praktek');
            $table->foreign('pasien_id')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_reservasi_bidan');
    }
}
