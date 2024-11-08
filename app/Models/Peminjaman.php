<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    // Specify the table name
    protected $table = 'peminjaman';

    // Specify the primary key
    protected $primaryKey = 'peminjamanid';

    // Disable timestamps if not used
    public $timestamps = false;

    // Mass assignable attributes
    protected $fillable = [
        'userid',
        'bukuid',
        'tanggalpeminjaman',
        'tanggalpengembalian',
        'jumlah',
        'statuspeminjaman'
    ];

    // Define relationships if necessary
    public function user()
    {
        return $this->belongsTo(User::class, 'userid', 'userid');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'bukuid', 'bukuid');
    }
}
