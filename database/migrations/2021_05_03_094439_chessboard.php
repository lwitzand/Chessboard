<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Chessboard extends Migration
{
    public function up()
    {
        Schema::create('chessboards', function (Blueprint $table) {
            $table->id();
            $table->integer('size');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chessboards');
    }
}
