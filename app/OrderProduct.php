<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_product';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'quantity'];

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id', 'id');
    }
}
