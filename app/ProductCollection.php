<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCollection extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_collection';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'collection_id'];

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
