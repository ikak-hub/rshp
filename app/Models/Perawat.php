<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perawat extends Model
{
    use HasFactory;

    protected $table = 'perawat';
    protected $primaryKey = 'id_perawat';
    public $timestamps = false;

    protected $fillable = [
        'alamat',
        'no_hp',
        'jenis_kelamin',
        'pendidikan',
        'id_user',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'iduser');
    }
}