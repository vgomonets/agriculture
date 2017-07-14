<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractorHobbie extends Model
{
    public function hobbie()
    {
        return $this->hasOne('App\Models\Hobbie', 'id', 'hobbie_id');
    }
}
