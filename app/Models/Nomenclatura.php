<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Номенклатура
 */
class Nomenclatura extends Model
{

    public function nomenclaturaGroup()
    {
        return $this->hasOne('App\Models\NomenclaturaGroup', 'id', 'nomenclatura_group_id');
    }

    public function unit()
    {
        return $this->hasOne('App\Models\Unit', 'id', 'unit_id');
    }

    public function nomenclaturaType()
    {
        return $this->hasOne('App\Models\NomenclaturaType', 'id', 'nomenclatura_type_id');
    }

    public function vat()
    {
        return $this->hasOne('App\Models\Vat', 'id', 'vat_id');
    }

    public static function getAll()
    {
        return static::with(['nomenclaturaGroup', 'unit', 'nomenclaturaType', 'vat'])
            ->get();
    }
}
