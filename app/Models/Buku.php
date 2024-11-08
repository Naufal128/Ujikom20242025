<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'buku';

    // Specify the primary key, if it's different from the default 'id'
    protected $primaryKey = 'bukuid';

    // Disable auto-increment if needed (if bukuid is not auto-incrementing)
    public $incrementing = true;

    // Specify the fillable fields
    protected $fillable = [
        'judul',
        'penulis',   // Updated from pengarang
        'penerbit',
        'tahunterbit', // No underscore
        'foto',     // Image column
        'deskripsi',
        'stok'
    ];

    // Define the relation between Buku and Kategori (Many-to-Many)
    public function kategoris()
    {
        return $this->belongsToMany(Kategori::class, 'kategoribuku_relasi', 'bukuid', 'kategoriid');
    }

    // Additional relationships or methods can be added here as needed
}