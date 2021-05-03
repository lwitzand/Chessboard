<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Piece extends Migration
{
    public function up()
    {
        Schema::create('pieces', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('tile_id');
            $table->string('name');
            $table->string('identifier');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pieces');
    }
}
