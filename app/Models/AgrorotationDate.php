<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgrorotationDate extends Model
{
    
    public static function getLastDate($date) {
        return static::where('date', '<', $date)
            ->orderBy('date', 'DESC')
            ->first();
    }
    
}
