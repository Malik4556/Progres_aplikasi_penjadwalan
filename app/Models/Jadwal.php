<?php

// app/Models/Jadwal.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwals';

    protected $fillable = [
        'dosen_waktu_id',
        'kelas_id',
        'semester',
        'dosen_matkul_id',
        'sks',
        'jam_mulai',
        'jam_selesai',
        'ruangan_id',
    ];

    public function dosenwaktu()
    {
        return $this->belongsTo(DosenWaktu::class, 'dosen_waktu_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function dosenmatkul()
    {
        return $this->belongsTo(DosenMatkul::class, 'dosen_matkul_id');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }
}
