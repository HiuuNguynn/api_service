<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    const ROLE_MANAGER = 'manager';
    const ROLE_ADMIN = 'admin';
    const ROLE_ADMIN_HEAD = 'admin_head';
    const ROLE_USER = 'user';   
    const STATUS_ACTIVE = 1;
    const STATUS_DEACTIVE = 0;
    const IS_HEAD_ADMIN = 1;
    const IS_NOT_HEAD_ADMIN = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'role',
        'is_head_admin',
        'department_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>  
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function person()
    {
        return $this->hasOne(Person::class, 'user_id', 'id');
    }
  
    public function scopeUserRole($user)
    {
        return $user->where('role', self::ROLE_USER);
    }

    public function scopeInactiveUser($user) 
    {
        return $user->where('status', self::STATUS_DEACTIVE);
    }

    public function scopeActiveUser($user) 
    {
        return $user->where('status', self::STATUS_ACTIVE);
    }

    public function scopeHeadAdmin($user)
    {
        return $user->where('is_head_admin', self::IS_HEAD_ADMIN);
    }

    public function department() {
        return $this->belongsTo(Department::class);
    }

    public function managedDepartment() {
        return $this->hasOne(Department::class, 'manager_id');
    }
    
}
