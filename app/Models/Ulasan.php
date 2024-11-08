<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasFactory;

    protected $table = 'ulasanbuku'; // Set table name
    protected $primaryKey = 'ulasanid'; // Primary key
    public $timestamps = false; // If there's no created_at or updated_at columns

    protected $fillable = [
        'userid',
        'bukuid',
        'ulasan',
        'rating'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'bukuid');
    }
}
