<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KoleksiPribadi extends Model
{
    use HasFactory;

    protected $table = 'koleksipribadi';

    protected $primaryKey = 'koleksiid';

    protected $fillable = ['userid', 'bukuid'];

    public $timestamps = false;

    // Define the relationship with the Buku model
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'bukuid', 'bukuid');
    }
}
