<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class Admin extends Authenticatable
{
    use EntrustUserTrait;

    protected $table = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'cp_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function swap()
    {
        $hash = bcrypt(auth()->user()->getKey().microtime());

        \Session::put('session_id', $hash);

        $this->session_id = $hash;
        $this->save();
    }

    public function roleUsers()
    {
        return $this->belongsToMany('App\RoleUser');
    }

    public function getGroupListAttribute()
    {
        return $this->roleUsers()->lists('role_id')->toArray();
    }
}
