<?php
/**
 * Created by PhpStorm.
 * User: Pham Van Hien
 * Date: 12/1/2015
 * Time: 10:03 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Taggable extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'taggable';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}