<?php

namespace App\Models;

use App\Models\Nomenclatura;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    public function nomenclatura()
    {
        return $this->hasOne(Nomenclatura::class, 'id', 'nomenclatura_id');
    }
}
