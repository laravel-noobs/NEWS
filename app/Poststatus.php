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
    protected $fillable = ['name', 'slug'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

}