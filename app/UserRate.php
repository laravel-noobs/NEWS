<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRate extends Model
{
    /**
     * @var string
     */
    protected $table = 'user_rate';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'rate'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public $timestamps = false;
}
