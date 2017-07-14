<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Traits\ContractorTrait;

/**
 * Контрагент (клиент)
 */
class Contractor extends Model
{
    use SoftDeletes, ContractorTrait;
    
    protected static $relationToUsersTable = 'relation_user_contractors';
    protected static $relationToUsersField = 'contractor_id';
    protected $softDelete = true;
    private $type = 'user';

    public static function getAll()
    {
        return static::with(['contractorGroup', 'contractorActivity', 'region', 'contact'])
            ->get();
    }
    
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'relation_user_contractors');
    }
    
    public function companies()
    {
        return $this->belongsToMany('App\Models\Company', 'relation_contractors_companies');
    }
    
    public function relationCompanies()
    {
        return $this->hasMany('App\Models\RelationContractorCompany');
    }

    /**
     * Count contractors by manager id
     */
    public static function countContractorsByManagerId($managerId)
    {
        $count = DB::table('contractors as c')
            ->leftJoin('tasks as t', 't.contractor_id', '=', 'c.id')
            ->select(DB::raw('COUNT(c.id) as cnt'))
            ->where([
                't.creator_id' => $managerId,
            ])
            ->first();
        if (empty($count)) {
            return false;
        }
        return $count->cnt;
    }
}
