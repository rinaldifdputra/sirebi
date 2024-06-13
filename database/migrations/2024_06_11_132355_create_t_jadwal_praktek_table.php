<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTJadwalPraktekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_jadwal_praktek', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->uuid('id', 36)->primary();
            $table->date('tanggal');
            $table->uuid('jam_praktek_id', 36);
            $table->uuid('bidan_id', 36);
            $table->integer('kuota');
            $table->uuid('created_by', 36);
            $table->uuid('updated_by', 36);
            $table->timestamps();
        });

        Schema::table('t_jadwal_praktek', function ($table) {
            $table->foreign('jam_praktek_id')->references('id')->on('t_jam_praktek');
            $table->foreign('bidan_id')->references('id')->on('users');
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
        Schema::dropIfExists('t_jadwal_praktek');
    }
}
