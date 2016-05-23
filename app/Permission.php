<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permission';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'label'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    public $timestamps = false;
    /**
     * @var array
     */
    protected $hidden = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role', 'role_permission', 'permission_id', 'role_id');
    }

    public function isGrantedTo(Role $role)
    {
        foreach($this->roles as $r)
            if($r->name == $role->name)
                return true;
        return false;
    }
}
