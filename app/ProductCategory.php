<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description'];

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
     * A category can belongs to another category as its child
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('App\ProductCategory', 'parent_id', 'id');
    }

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
        return $this->hasOne('App\Product', 'category_id')
            ->selectRaw('category_id, count(*) as aggregate')
            ->groupBy('category_id');
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

    /**
     *
     * Count number of sub-categories belongs to this category
     *
     * @return mixed
     */
    public function subCategoriesCount()
    {
        return $this->hasOne('App\ProductCategory', 'parent_id', 'id')
            ->selectRaw('parent_id, count(*) as aggregate')
            ->groupBy('parent_id');
    }

    /**
     *
     * subCategoriesCount attribute to count number of sub-categories belongs to this category
     *
     * @return int
     */
    public function getSubCategoriesCountAttribute()
    {
        if (!$this->relationLoaded('subCategoriesCount'))
            $this->load('subCategoriesCount');
        $related = $this->getRelation('subCategoriesCount');
        return ($related) ? (int) $related->aggregate : 0;
    }
}
