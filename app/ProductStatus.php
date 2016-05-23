<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductStatus extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_status';

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
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('App\Product','status_id','id');
    }

    /**
     * @TODO
     *
     * @param $name
     * @return int|null
     */
    public static function getStatusIdByName($name)
    {
        switch($name)
        {
            case 'outofstock':
                return 1;
            case 'available':
                return 2;
            case 'disabled':
                return 3;
            default:
                return null;
        }
    }
}
