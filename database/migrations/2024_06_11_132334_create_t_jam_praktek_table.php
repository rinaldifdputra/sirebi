<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTJamPraktekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_jam_praktek', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->uuid('id', 36)->primary();
            $table->string('jam_mulai', 5);
            $table->string('jam_selesai', 5);
            $table->uuid('created_by', 36);
            $table->uuid('updated_by', 36);
            $table->timestamps();
        });

        Schema::table('t_jam_praktek', function ($table) {
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
        Schema::dropIfExists('t_jam_praktek');
    }
}
