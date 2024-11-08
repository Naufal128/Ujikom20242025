<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeStatuspeminjamanToEnumInPeminjamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Change statuspeminjaman column to ENUM with values 'Dipinjam' and 'Kembali'
            $table->enum('statuspeminjaman', ['Dipinjam', 'Kembali'])
                  ->default('Dipinjam')
                  ->change();  // Use change() to modify the existing column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Revert back to original string type if rolled back
            $table->string('statuspeminjaman', 50)->change();
        });
    }
}
