<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    
    public function gender()
    {
        return $this->hasOne('App\Models\Gender', 'id', 'gender_id');
    }
    
    public function type()
    {
        return $this->hasOne('App\Models\FamilyType', 'id', 'family_type_id');
    }
    
}
