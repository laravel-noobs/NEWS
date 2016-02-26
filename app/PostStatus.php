<?php
/**
 * Created by PhpStorm.
 * User: Pham Van Hien
 * Date: 12/1/2015
 * Time: 10:01 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class PostStatus extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'post_status';

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
    protected $hidden = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany('App\Post','status_id','id');
    }

    /**
     * @param $name
     * @return int|null
     */
    public static function getStatusIdByName($name)
    {
        switch($name)
        {
            case 'draft':
                return 1;
            case 'pending':
                return 2;
            case 'approved':
                return 3;
            case 'trash':
                return 4;
            default:
                return null;
        }
    }
}