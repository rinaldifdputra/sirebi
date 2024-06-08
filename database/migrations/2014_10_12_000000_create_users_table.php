<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id', 36)->primary();
            $table->string('full_name');
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['Laki-Laki', 'Perempuan']);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['Bidan', 'Pasien', 'Admin']);
            $table->rememberToken();
            $table->uuid('created_by', 36);
            $table->uuid('updated_by', 36);
            $table->timestamps();
        });

        Schema::table('t_schedule', function ($table) {
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
        Schema::dropIfExists('users');
    }
}
