<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusDosenWaktu extends Model
{
    use HasFactory;
    protected $fillable = [
        'status',
    ];
}
