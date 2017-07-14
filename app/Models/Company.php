<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ContractorTrait;

class Company extends Model
{
    use SoftDeletes, ContractorTrait;
    
    protected static $relationToUsersTable = 'relation_user_companies';
    protected static $relationToUsersField = 'company_id';
    protected $softDelete = true;
    protected $guarded = [
        'date',
        'is_buyer',
        'is_supplier',
        'is_not_residend',
        'contractor_group_id',
        'name',
        'full_name',
        'inn',
        'code_egrpou',
        'number_vat',
        'region_id',
        'contractor_activity_id',
    ];
    private $type = 'company';
    
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'relation_user_companies');
    }

    public function contractors()
    {
        return $this->belongsToMany('App\Models\Contractor', 'relation_contractors_companies');
    }
    
    public function agrorotations()
    {
        return $this->hasMany('App\Models\Agrorotation', 'company_id');
    }
}
