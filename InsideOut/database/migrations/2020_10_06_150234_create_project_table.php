<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progetto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utente')->references('id')->on('users')->onDelete('cascade');
            $table->string('nome');
            $table->dateTime('dataCreazione');
            $table->string('descrizione');
            $table->json('risultatiAnalisi')->nullable();
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
        Schema::dropIfExists('progetto');
    }
}
