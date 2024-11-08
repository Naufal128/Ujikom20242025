<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTables extends Migration
{
    public function up()
    {
        // Create the 'users' table
        Schema::create('users', function (
            eprint $table) {
            $table->increments('userid'); // Primary Key, Auto-incrementing integer
            $table->string('username', 255); // Username varchar(255)
            $table->string('password', 255); // Password varchar(255)
            $table->string('email', 255)->unique(); // Email varchar(255), unique
            $table->string('namalengkap', 255); // Namalengkap varchar(255)
            $table->text('alamat'); // Alamat text
            $table->string('telepon', 255);
            $table->timestamps(); // created_at and updated_at
        });

        // Create the 'buku' table first to prevent reference errors
        Schema::create('buku', function (Blueprint $table) {
            $table->increments('bukuid'); // Primary Key, Auto-incrementing integer
            $table->string('judul', 255); // Book title varchar(255)
            $table->string('penulis', 255); // Author name varchar(255)
            $table->string('penerbit', 255); // Publisher name varchar(255)
            $table->integer('tahunterbit'); // Publication year int(11)
            $table->timestamps(); // created_at and updated_at
        });

        // Create the 'koleksipribadi' table
        Schema::create('koleksipribadi', function (Blueprint $table) {
            $table->increments('koleksiid'); // Primary Key, Auto-incrementing integer
            $table->integer('userid')->unsigned(); // Foreign Key referencing users
            $table->integer('bukuid')->unsigned(); // Reference to bukuid
            $table->foreign('userid')->references('userid')->on('users')->onDelete('cascade');
            $table->foreign('bukuid')->references('bukuid')->on('buku')->onDelete('cascade');
            $table->timestamps(); // created_at and updated_at
        });

        // Create the 'peminjaman' table
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->increments('peminjamanid'); // Primary Key, Auto-incrementing integer
            $table->integer('userid')->unsigned(); // Foreign Key referencing users
            $table->integer('bukuid')->unsigned(); // Reference to bukuid
            $table->date('tanggalpeminjaman'); // Date of loan
            $table->date('tanggalpengembalian')->nullable(); // Date of return, nullable
            $table->string('statuspeminjaman', 50); // Status of loan varchar(50)
            $table->foreign('userid')->references('userid')->on('users')->onDelete('cascade');
            $table->foreign('bukuid')->references('bukuid')->on('buku')->onDelete('cascade');
            $table->timestamps(); // created_at and updated_at
        });

        // Create the 'ulasanbuku' table (after 'buku' and 'users')
        Schema::create('ulasanbuku', function (Blueprint $table) {
            $table->increments('ulasanid'); // Primary Key, Auto-incrementing integer
            $table->integer('userid')->unsigned(); // Foreign Key referencing users
            $table->integer('bukuid')->unsigned(); // Foreign Key referencing books
            $table->text('ulasan'); // Review text
            $table->integer('rating')->unsigned(); // Rating int(11)
            $table->foreign('userid')->references('userid')->on('users')->onDelete('cascade');
            $table->foreign('bukuid')->references('bukuid')->on('buku')->onDelete('cascade');
            $table->timestamps(); // created_at and updated_at
        });

        // Create the 'kategoribuku' table
        Schema::create('kategoribuku', function (Blueprint $table) {
            $table->increments('kategoriid'); // Primary Key, Auto-incrementing integer
            $table->string('namakategori', 255); // Category name varchar(255)
            $table->timestamps(); // created_at and updated_at
        });

        // Create the 'kategoribuku_relasi' table
        Schema::create('kategoribuku_relasi', function (Blueprint $table) {
            $table->increments('kategoribukuid'); // Primary Key, Auto-incrementing integer
            $table->integer('bukuid')->unsigned(); // Foreign Key referencing books
            $table->integer('kategoriid')->unsigned(); // Foreign Key referencing categories
            $table->foreign('bukuid')->references('bukuid')->on('buku')->onDelete('cascade');
            $table->foreign('kategoriid')->references('kategoriid')->on('kategoribuku')->onDelete('cascade');
            $table->timestamps(); // created_at and updated_at
        });
    }

    public function down()
    {
        // Drop the 'kategoribuku_relasi' table first due to foreign key dependencies
        Schema::dropIfExists('kategoribuku_relasi');
        // Drop the 'kategoribuku' table
        Schema::dropIfExists('kategoribuku');
        // Drop the 'buku' table
        Schema::dropIfExists('buku');
        // Drop the 'ulasanbuku' table
        Schema::dropIfExists('ulasanbuku');
        // Drop the 'peminjaman' table
        Schema::dropIfExists('peminjaman');
        // Drop the 'koleksipribadi' table
        Schema::dropIfExists('koleksipribadi');
        // Drop the 'users' table
        Schema::dropIfExists('users');
    }
}
