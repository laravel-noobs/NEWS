<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProvinceType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'province_type';

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
    public function provinces()
    {
        return $this->hasMany('App\Province','type_id', 'id');
    }
}
