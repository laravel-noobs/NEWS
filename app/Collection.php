<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'collection';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'label', 'slug', 'description', 'image'];

    /**
     * @var bool
     */
    public $timestamps = true;
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function products()
    {
        return $this->belongsToMany('App\Product', 'product_collection');
    }

    /**
     * Count number of products belong to this collection
     *
     * @return mixed
     */
    public function productsCount()
    {
        return $this->hasOne('App\ProductCollection')
            ->selectRaw('collection_id, count(*) as aggregate')
            ->groupBy('collection_id');
    }
    /**
     * Count number of products belong to this collection
     *
     * @return int
     */
    public function getProductsCountAttribute()
    {
        if (!$this->relationLoaded('productsCount'))
            $this->load('productsCount');
        $related = $this->getRelation('productsCount');
        return ($related) ? (int) $related->aggregate : 0;
    }
}
