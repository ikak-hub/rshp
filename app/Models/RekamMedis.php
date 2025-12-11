<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis';
    protected $primaryKey = 'idrekam_medis';
    public $timestamps = false; // Hanya menggunakan created_at
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'created_at',
        'anamnesa',
        'temuan_klinis',
        'diagnosa',
        'idpet',
        'idreservasi_dokter',
        'dokter_pemeriksa',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Relasi ke Pet
    public function pet()
    {
        return $this->belongsTo(Pet::class, 'idpet', 'idpet');
    }

    // Relasi ke TemuDokter
    public function temuDokter()
    {
        return $this->belongsTo(TemuDokter::class, 'idreservasi_dokter', 'idreservasi_dokter');
    }

    // Relasi ke RoleUser (dokter pemeriksa)
    public function dokter()
    {
        return $this->belongsTo(RoleUser::class, 'dokter_pemeriksa', 'idrole_user');
    }

    // Relasi ke DetailRekamMedis
    public function detailRekamMedis()
    {
        return $this->hasMany(DetailRekamMedis::class, 'idrekam_medis', 'idrekam_medis');
    }
}