<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductBrand extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_brand';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'label', 'slug', 'description'];

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
     *
     * A product category has many products
     *
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('App\Product');
    }

    /**
     *
     * Count number of posts belongs to this category
     *
     * @return mixed
     */
    public function productsCount()
    {
        return $this->hasOne('App\Product', 'brand_id')
            ->selectRaw('brand_id, count(*) as aggregate')
            ->groupBy('brand_id');
    }

    /**
     *
     * postsCount attribute to count number of post belongs to this category
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
