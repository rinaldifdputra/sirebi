<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsTentangKamiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_tentang_kami', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->uuid('id', 36)->primary();
            $table->string('judul');
            $table->string('gambar');
            $table->text('deskripsi');
            $table->uuid('created_by', 36);
            $table->uuid('updated_by', 36);
            $table->timestamps();
        });

        Schema::table('cms_tentang_kami', function ($table) {
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
        Schema::dropIfExists('cms_tentang_kami');
    }
}
