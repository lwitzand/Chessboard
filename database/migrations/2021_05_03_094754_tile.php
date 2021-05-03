<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tile extends Migration
{
    public function up()
    {
        Schema::create('tiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('chessboard_id');
            $table->string('file');
            $table->integer('rank');
            $table->boolean('save');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tiles');
    }
}
