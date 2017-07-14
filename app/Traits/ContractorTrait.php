<?php

namespace App\Traits;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Models\Contractor;
use App\Models\Company;
use App\Models\User;

trait ContractorTrait
{
//    protected static $relationToUsersTable;
//    protected static $relationToUsersField;
    
    public function region()
    {
        return $this->hasOne('App\Models\Region', 'id', 'region_id');
    }

    public function contractorGroup()
    {
        return $this->hasOne('App\Models\ContractorGroup', 'id', 'contractor_group_id');
    }

    public function contractorActivity()
    {
        return $this->hasOne('App\Models\ContractorActivities', 'id', 'contractor_activity_id');
    }

    public function contact()
    {
        return $this->morphOne('App\Models\ContractorContacts', 'contact');
    }
    
    public function task()
    {
        return $this->morphOne('App\Models\Tasks', 'contractor');
    }
    
    public static function getByManager ($userId, $groupId)
    {
        $table = (new self())->getTable();
        
        $contractors = self::with(['contractorGroup', 'contractorActivity', 'region', 'contact']);
        if (!empty($groupId)) {
            $contractors->where(['contractor_group_id' => $groupId]);
        }
        
        $roles = Role::getByUserId($userId);
        // порядок проверки ролей важен (от старшей к меньшей)
        
        if(in_array('head', $roles)) {
            return $contractors;
        }
        
        $user = User::where(['id' => $userId])->first();
        if (in_array('regional head', $roles)) {
            $contractors->join(static::$relationToUsersTable . ' as rel', 'rel.' . self::$relationToUsersField, '=', "{$table}.id");
            $contractors->join('users', 'users.id', '=', 'rel.user_id');
            $contractors->where(['region_id' => $user->region_id]);
            return $contractors;
        }
        
        if (in_array('manager', $roles)) {
            $contractors->join(self::$relationToUsersTable . ' as rel', 'rel.' . self::$relationToUsersField, '=', "{$table}.id");
            $contractors->where(['rel.user_id' => $user->id]);
            return $contractors;
        }
        
        $contractors->whereNull('id'); // ничего не найдено
        return $contractors;
    }
    
    public function getType()
    {
        if(empty($this->type)) {
            return false;
        }
        return $this->type;
    }
    
    public static function countByUserId($user_id) {
        return static::where('user_id', $user_id)
            ->count();
    }
}