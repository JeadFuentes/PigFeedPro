<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feeding extends Model
{
    use HasFactory;

    protected $table = "feeding";
    protected $fillable = [
        'desc',
        'unit',
        'time',
        'status',
    ];
}
