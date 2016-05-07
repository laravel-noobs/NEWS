<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'phone', 'customer_name', 'delivery_address', 'delivery_ward_id', 'delivery_note'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes be mutated to Carbon object
     *
     * @var array
     */
    protected $dates = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo('App\OrderStatus', 'status_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany('App\Product', 'order_product', 'order_id', 'product_id')->withPivot(['price', 'quantity']);
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function scopeHasStatus($query, $status_id)
    {
        if(!$status_id)
            return;
        $query->where('status_id', '=', $status_id);
    }
    public function scopeHasId($query, $id)
    {
        if(!$id)
            return;
        $query->where('id', '=', $id);
    }
    public function scopeHasCustomer($query, $customer_name)
    {
        if(!$customer_name)
            return;
        $query->where('customer_name', 'like', $customer_name);
    }
    public function scopeCreatedFrom($query, $date)
    {
        if(!$date)
            return;
        $query->where('created_at', '>=', $date);
    }
    public function scopeCreatedTo($query, $date)
    {
        if(!$date)
            return;
        $query->where('created_at', '<=', $date);
    }
    public function getAmountAttribute()
    {
        $total = 0;
        foreach($this->products as $product)
            $total += $product->pivot->price * $product->pivot->quantity;
        return $total;
    }
}
