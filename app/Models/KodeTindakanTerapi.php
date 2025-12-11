<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KodeTindakanTerapi extends Model
{
    protected $table = 'kode_tindakan_terapi';
    protected $primaryKey = 'idkode_tindakan_terapi';
    protected $fillable = [
        'kode_tindakan', 
        'deskripsi_tindakan', 
        'idkategori',
        'idkategori_klinis'
    ];
    
    // Relasi ke Hewan
    public function hewan()
    {
        return $this->hasMany(Hewan::class, 'idkode_tindakan_terapi', 'idkode_tindakan_terapi');
    }
    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'idkategori', 'idkategori');
    }

    // Relasi kategori klinis
    public function kategoriKlinis()
    {
        return $this->belongsTo(KategoriKlinis::class, 'idkategori_klinis', 'idkategori_klinis');
    }

    // mematikan created_at dan updated_at
    public $timestamps = false;
}
