<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsTestimoniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_testimoni', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->uuid('id', 36)->primary();
            $table->uuid('pasien_id', 36);
            $table->text('deskripsi');
            $table->uuid('created_by', 36);
            $table->uuid('updated_by', 36);
            $table->timestamps();
        });

        Schema::table('cms_testimoni', function ($table) {
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
        Schema::dropIfExists('cms_testimoni');
    }
}
