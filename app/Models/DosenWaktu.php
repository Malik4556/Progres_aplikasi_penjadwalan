<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenWaktu extends Model
{
    use HasFactory;
    protected $fillable = [
        'dosen_id',
        'hari_id',
        'jam_id',
    ];

    /**
     * Get the user that owns the DosenMatkul
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id', 'id');
    }

    public function hari()
    {
        return $this->belongsTo(Hari::class, 'hari_id', 'id');
    }

    public function jam()
    {
        return $this->belongsTo(Jam::class, 'jam_id', 'id');
    }
}
