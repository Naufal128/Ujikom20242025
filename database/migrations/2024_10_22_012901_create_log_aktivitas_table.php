<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogAktivitasTable extends Migration
{
    public function up()
    {
        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->increments('aktivitasid'); // Primary Key, Auto-incrementing integer
            $table->integer('userid')->unsigned()->nullable(); // Foreign Key referencing users (nullable for pengelola activities)
            $table->integer('pengelolaid')->unsigned()->nullable(); // Foreign Key referencing pengelola (nullable for user activities)
            $table->text('deskripsi_aktivitas'); // Description of the activity
            $table->timestamps(); // created_at and updated_at

            // Foreign key constraints
            $table->foreign('userid')->references('userid')->on('users')->onDelete('cascade');
            $table->foreign('pengelolaid')->references('pengelolaid')->on('pengelola')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('log_aktivitas');
    }
}
