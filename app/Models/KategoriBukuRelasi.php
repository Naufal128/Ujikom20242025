<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBukuRelasi extends Model
{
    use HasFactory;

    protected $table = 'kategoribuku_relasi';
    protected $primaryKey = 'kategoribukuid'; // Assuming this is the primary key
    public $incrementing = true; // Set to false if the primary key is not auto-incrementing
    protected $fillable = ['bukuid', 'kategoriid'];

    // Define the relationship with Buku
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'bukuid', 'bukuid');
    }

    // Define the relationship with Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategoriid', 'kategoriid');
    }
}
