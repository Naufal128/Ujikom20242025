<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoribuku';
    protected $primaryKey = 'kategoriid';
    public $incrementing = true;
    protected $fillable = ['namakategori'];
    public $timestamps = true;

    // Define a many-to-many relationship with Buku
    public function bukus()
    {
        return $this->belongsToMany(Buku::class, 'kategoribuku_relasi', 'kategoriid', 'bukuid');
    }
}

