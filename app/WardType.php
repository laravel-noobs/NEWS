<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WardType
 * @package App
 */
class WardType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ward_type';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The property define model uses timestamps or not
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wards()
    {
        return $this->hasMany('App\Ward','type_id', 'id');
    }
}
