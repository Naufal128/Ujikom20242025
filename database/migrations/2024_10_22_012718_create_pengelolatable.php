<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengelolaTable extends Migration
{
    public function up()
    {
        Schema::create('pengelola', function (Blueprint $table) {
            $table->increments('pengelolaid'); // Primary Key, Auto-incrementing integer
            $table->integer('level'); // Level of the pengelola
            $table->string('username', 255); // Username varchar(255)
            $table->string('password', 255); // Password varchar(255)
            $table->string('email', 255)->unique(); // Email varchar(255), unique
            $table->timestamps(); // created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengelola');
    }
}
