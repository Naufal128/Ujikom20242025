<?php
 
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $primaryKey = 'userid'; // Set userid as the primary key

    // Specify which fields are mass assignable
    protected $fillable = [
        'username', 'password', 'email', 'namalengkap', 'alamat', 'telepon',
    ];

    // Hide sensitive fields when serialized to arrays or JSON
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Cast fields to native types
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
