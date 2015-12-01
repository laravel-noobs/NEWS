<?php
/**
 * Created by PhpStorm.
 * User: Pham Van Hien
 * Date: 12/1/2015
 * Time: 10:03 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Post_Tag extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'post_tag';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}