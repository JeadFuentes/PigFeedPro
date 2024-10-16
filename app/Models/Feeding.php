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

    public function scopeSearch($query, $val){
        return $query->where(function($q) use ($val) {
            $q->where('id', 'like', '%'.$val.'%')
              ->orWhere('desc', 'like', '%'.$val.'%')
              ->orWhere('unit', 'like', '%'.$val.'%')
              ->orWhere('time', 'like', '%'.$val.'%')
              ->orWhere('status', 'like', '%'.$val.'%');
        });
    }
}
