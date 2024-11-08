<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id('imageid');  // Primary key for image id
            $table->string('filename'); // Filename or path to the image
            $table->string('type')->nullable();  // Type of the image (e.g., 'jpg', 'png')
            $table->unsignedBigInteger('size')->nullable(); // Image size in bytes
            $table->timestamps();  // To store created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
