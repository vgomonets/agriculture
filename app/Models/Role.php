<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Role;

class Role extends Model
{
    
    private $inst = null;
    private $roles = null;
    
    /**
     * Get all roles
     * @return Role[]
     */
    private function getRoles()
    {
        if ($this->roles === null) {
            $this->roles = static::where(['disabled' => 0])
                ->get();
        }
        return $this->roles;
    }
    
    /**
     * Проверить, есть ли у пользователя роль
     * @param type $userId - id пользователя
     * @param string|string[] $roleNames - список ролей
     * @param type $fullOverlay - полное совпадение ролей (true) 
     * или хотя бы одной роли (false)
     * @return boolean
     */
    public static function userIsHaveRoles($userId, $roleNames, $fullOverlay = false)
    {
        $roleNames = (array) $roleNames;
        $roles = static::getByUserId($userId);
        if(empty($roleNames) || empty($roles)) {
            return false;
        }
        
        foreach($roleNames as $roleName) {
            if (!in_array($roleName, $roles) && $fullOverlay === true) {
                return false;
            } elseif (in_array($roleName, $roles) && $fullOverlay === false) {
                return true;
            }
        }
        return $fullOverlay;
    }
    
    /**
     * Получить вложенные роли
     * @param integer|integer[] $parentRoles
     * @return string[] $roles
     */
    public static function getChildRoles($parentRoles)
    {
        $parentRoles = (array) $parentRoles;
        $roles = [];
        do {
            $r = Role::whereIn('parent_role_id', $parentRoles)
                ->where(['disabled' => 0])
                ->get();
            $role = array_pluck($r, 'name', 'id');
            $parentRoles = array_keys($role);
            $roles += $role;
        } while(!empty($parentRoles));
        return $roles;
    }

    /**
     * Получить все роли по $userId
     * @param integer $userId
     * @return string[]
     */
    public static function getByUserId($userId)
    {
        $r = DB::table('roles as r')
            ->select(['r.*', 'rur.user_id'])
            ->join('relation_user_roles as rur', 'r.id', '=','rur.role_id')
            ->where([
                'rur.user_id' => $userId,
                'r.disabled' => 0,
            ])
            ->get(); 
        
        $roles = array_pluck($r, 'name', 'id');
        return $roles + static::getChildRoles(array_keys($roles));
    }

    public static function instance()
    {
        if ($this->inst === null) {
            $this->inst = new static();
        }
        return $this->inst;
    }
    
}
