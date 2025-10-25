<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'idkategori';
    protected $fillable = ['nama_kategori'];
    
    public function hewan()
    {
        return $this->hasMany(Hewan::class, 'idkategori', 'idkategori');
    }
}
