<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'role_id',
        'email',
        'password',
        'settings',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * The attributes that have all user permission
     *
     * @var array
     */
    protected $permissions = [];


    public function hasPermission($permission)
    {
        
        Cache::remember('user-permissions-' . $this->id, \Carbon\Carbon::now()->addSeconds(3), function () {
            return $this->getPermissions();
        });
        
        return in_array($permission, Cache::get('user-permissions-' . $this->id));

    }
    
    public function getPermissions()
    {
        $user_role = $this->getUserRole();
        if ($user_role) {
            return $user_role->getRolePermissionsAsCodesArray();
        }

        return $user_role ? $user_role : [];
    }

    
    public function getUserRole()
    {
        return Role::find($this->role_id);
    }

    
    
    public function getUserPermissions()
    {
        return UsersPermission::where('user_id', $this->id)->get();
    }


}
