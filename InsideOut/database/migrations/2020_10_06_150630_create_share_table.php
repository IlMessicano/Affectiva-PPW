<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('condivisione', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proprietario')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('collaboratore')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('progetto')->references('id')->on('progetto')->onDelete('cascade');
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
        Schema::dropIfExists('condivisione');
    }
}
