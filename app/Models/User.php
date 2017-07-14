<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class User extends Authenticatable
{
    const SALT = '2y$10$QavNbLstxdnVR4LZplgPrO';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'new_email',
        'phone',
        'password',
        'api_key',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Check hash for new mail
     * @param type $hash
     * @return boolean
     */
    public function hashCheckNewMail($new_email, $hash)
    {
        return Hash::check($new_email . self::SALT, $hash);
    }

    /**
     * Retrun hash for new mail
     * @return string
     */
    public function hashNewMail()
    {
        return Hash::make($this->new_email . self::SALT);
    }

    /**
     * Return link to confirm mail
     * @return string
     */
    public function linkConfirmMail()
    {
        return action('\App\Http\Controllers\Auth\PasswordController@confirmEmail', [
            'mail' => $this->new_email,
            'security' => $this->hashNewMail(),
        ]);
    }
    
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'relation_user_roles');
    }

    public function region()
    {
        return $this->belongsTo('App\Models\Region', 'region_id', 'id');
    }

    /**
     * Check role
     * @param string $role_name
     * @return boolean
     */
    public function hasRole($role_name)
    {
        return Role::userIsHaveRoles($this->id, $role_name);
    }
}
