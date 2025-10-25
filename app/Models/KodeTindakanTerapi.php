<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KodeTindakanTerapi extends Model
{
    protected $table = 'kode_tindakan_terapi';
    protected $primaryKey = 'idkode_tindakan_terapi';
    protected $fillable = ['kode_tindakan', 'deskripsi_tindakan', 'biaya_tindakan'];
    protected $casts = [
        'biaya_tindakan' => 'decimal:2',
    ];
    public function hewan()
    {
        return $this->hasMany(Hewan::class, 'idkode_tindakan_terapi', 'idkode_tindakan_terapi');
    }
}
