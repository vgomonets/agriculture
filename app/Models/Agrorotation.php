<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agrorotation extends Model
{
    public function Agroculture()
    {
        return $this->hasOne('App\Models\Agroculture', 'id', 'agroculture_id');
    }
    
    public function Chemical()
    {
        return $this->hasOne('App\Models\Chemical', 'id', 'chemical_id');
    }
    
    public function Unit()
    {
        return $this->hasOne('App\Models\AgrorotationUnit', 'id', 'unit_id');
    }
    
    public function User()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    
    public function Company()
    {
        return $this->hasOne('App\Models\Company', 'id', 'company_id');
    }
        
}
