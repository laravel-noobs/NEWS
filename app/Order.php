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
    protected $fillable = ['user_id', 'phone', 'customer_name', 'delivery_address', 'delivery_ward_id', 'delivery_note', 'email'];

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

    public function delivery_ward()
    {
        return $this->belongsTo('App\Ward', 'delivery_ward_id', 'id');
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

    public function isDeliveryInfomationChangable()
    {
        return ($this->status_id == $this->getStatusIdByName('pending') ||
            $this->status_id == $this->getStatusIdByName('approved'));
    }

    public function isPending()
    {
        return $this->status_id == 1;
    }

    public function isApproved()
    {
        return $this->status_id == 2;
    }

    public function isDelivering()
    {
        return $this->status_id == 3;
    }

    public function isCanceled()
    {
        return $this->status_id == 4;
    }

    public function isCompleted()
    {
        return $this->status_id == 5;
    }
    public function getStatusIdByName($name)
    {
        switch($name)
        {
            case 'pending':
                return 1;
            case 'approved':
                return 2;
            case 'delivering':
                return 3;
            case 'canceled':
                return 4;
            case 'completed':
                return 5;
            default:
                return null;
        }
    }

    public function approve()
    {
        $this->status_id = Order::getStatusIdByName('approved');
        return $this->save();
    }

    public function deliver()
    {
        $this->status_id = Order::getStatusIdByName('delivering');
        return $this->save();
    }

    public function complete()
    {
        $this->status_id = Order::getStatusIdByName('completed');
        return $this->save();
    }

    public function cancel()
    {
        $this->status_id = Order::getStatusIdByName('canceled');
        return $this->save();
    }
}
