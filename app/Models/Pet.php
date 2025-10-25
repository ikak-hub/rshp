<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $table = 'pet';
    protected $primaryKey = 'idpet';
    protected $fillable = ['nama', 'tanggal_lahir', 'warna_tanda','jenis_kelamin', 'idras_hewan', 'idpemilik'];

    public function pemilik()
    {
        return $this->belongsTo(Pemilik::class, 'idpemilik', 'idpemilik');
    }

    public function ras()
    {
        return $this->belongsTo(RasHewan::class, 'idras_hewan', 'idras_hewan');
    }
}
