<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoribukuAndKategoribukuRelasiTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create kategoribuku table
        Schema::create('kategoribuku', function (Blueprint $table) {
            $table->increments('kategoriid'); // kategoriid as int(11)
            $table->string('namakategori', 255); // namakategori as varchar(255)
            $table->timestamps(); // created_at and updated_at
        });

        // Create kategoribuku_relasi table
        Schema::create('kategoribuku_relasi', function (Blueprint $table) {
            $table->increments('kategoribukuid'); // kategoribukuid as int(11)
            $table->unsignedInteger('bukuid'); // bukuid as int(11)
            $table->unsignedInteger('kategoriid'); // kategoriid as int(11)
            $table->timestamps(); // created_at and updated_at

            // Define foreign key constraints
            $table->foreign('bukuid')->references('bukuid')->on('buku')->onDelete('cascade');
            $table->foreign('kategoriid')->references('kategoriid')->on('kategoribuku')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop kategoribuku_relasi first due to foreign key dependency
        Schema::dropIfExists('kategoribuku_relasi');
        Schema::dropIfExists('kategoribuku');
    }}