<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jam extends Model
{
    use HasFactory;
    protected $fillable = [
        'range_jam',
    ];

    // Di model Jam
public function getJamMulaiAttribute()
{
    $range = explode(' - ', $this->range_jam);
    return $range[0];
}

public function getJamSelesaiAttribute()
{
    $range = explode(' - ', $this->range_jam);
    return isset($range[1]) ? $range[1] : null;
}

}
