<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles;

    protected $table = 'users';
    protected $guarded = [];
    protected $appends = ['full_name','role_names'];

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


    public function role(){
        return $this->hasOne(Role::class);
    }

    public function getRoleNamesAttribute()
    {
        $names = "";

        foreach($this->roles as $role){
            $names .= ','. $role->name;
        }
        return $names;
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }



    public function getImageAttribute($value)
    {
        return $value != null ? url('/images/') . '/' . $value : '';
    }


}
