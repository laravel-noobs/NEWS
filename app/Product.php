<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description', 'category_id', 'price', 'image'];

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

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable', 'taggable');
    }

    public function tagsCount()
    {
        DB::enableQueryLog();
        return $this->hasMany('App\Taggable', 'taggable_id')
            ->selectRaw('taggable_id, count(*) as aggregate')
            ->whereRaw("taggable_type = '" . str_replace('\\', '\\\\', static::class) . "'")
            ->groupBy('taggable_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\ProductCategory', 'category_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo('App\ProductStatus', 'status_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo('App\ProductBrand', 'brand_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany('App\ProductReview', 'product_id', 'id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orders()
    {
        return $this->belongsToMany('App\Order', 'order_product', 'product_id', 'order_id')->withPivot(['price', 'quantity']);
    }

    public function scopeSearchInName($query, $term)
    {
        return $query->where('name', 'like', "%{$term}%");
    }
}
