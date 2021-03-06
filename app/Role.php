<?php
/**
 * Created by PhpStorm.
 * User: Pham Van Hien
 * Date: 12/1/2015
 * Time: 10:05 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'role';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'label', 'slug'];

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
    public function users()
    {
        return $this->hasMany('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Permission', 'role_permission', 'role_id', 'permission_id');
    }

    /**
     * @param Permission $permission
     * @return array
     */
    public function givePermission(Permission $permission)
    {
        return $this->permissions()->save($permission);
    }

    public static function getRoleIdByName($role)
    {
        switch($role)
        {
            case 'administrator':
                return 1;
            case 'editor':
                return 2;
            case 'collaborator':
                return 3;
            default:
                return null;
        }
    }
}