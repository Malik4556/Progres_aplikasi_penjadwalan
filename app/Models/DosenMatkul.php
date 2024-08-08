<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenMatkul extends Model
{
    use HasFactory;
    protected $fillable = [
        'dosen_id',
        'matakuliah_id',
        'semester',
        'sks'
    ];

    public function setSksAttribute($value)
    {
        // Mengisi nilai sks otomatis dari matakuliah_id
        if ($this->attributes['matakuliah_id']) {
            $matakuliah = Matakuliah::find($this->attributes['matakuliah_id']);
            $this->attributes['sks'] = $matakuliah ? $matakuliah->sks : 0;
        }
    }

    /**
     * Get the user that owns the DosenMatkul
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id');
    }

}
