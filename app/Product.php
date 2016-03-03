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

    public function collections()
    {
        return $this->belongsToMany('App\Collection', 'product_collection');
    }

    /**
     * Count number of collections this product belongs to
     *
     * @return mixed
     */
    public function collectionsCount()
    {
        return $this->hasOne('App\ProductCollection')
            ->selectRaw('collection_id, count(*) as aggregate')
            ->groupBy('collection_id');
    }
    /**
     * Count number of collections this product belongs to
     *
     * @return int
     */
    public function getCollectionsCountAttribute()
    {
        if (!$this->relationLoaded('productsCount'))
            $this->load('productsCount');
        $related = $this->getRelation('productsCount');
        return ($related) ? (int) $related->aggregate : 0;
    }

    /**
     *
     * Count number of comments belongs to this product
     *
     * @return mixed
     */
    public function commentsCount()
    {
        return $this->hasOne('App\Comment', 'commentable_id')
            ->selectRaw('commentable_id, count(*) as aggregate')
            ->whereRaw("commentable_type = '" . str_replace('\\', '\\\\', static::class) . "'")
            ->groupBy('commentable_id');
    }

    /**
     *
     * commentsCount attribute to count number of comments belongs to this product
     *
     * @return int
     */
    public function getCommentsCountAttribute()
    {
        if (!$this->relationLoaded('commentsCount'))
            $this->load('commentsCount');
        $related = $this->getRelation('commentsCount');
        return ($related) ? (int) $related->aggregate : 0;
    }

    /**
     *
     * Count number of feedbacks belongs to this product
     *
     * @return mixed
     */
    public function feedbacksCount()
    {
        return $this->hasOne('App\Feedback', 'feedbackable_id')
            ->selectRaw('feedbackable_id, count(*) as aggregate')
            ->whereRaw("feedbackable_type = '" . str_replace('\\', '\\\\', static::class) . "'")
            ->groupBy('feedbackable_id');
    }

    /**
     *
     * feedbacksCount attribute to count number of feedbacks belongs to this product
     *
     * @return int
     */
    public function getFeedbacksCountAttribute()
    {
        if (!$this->relationLoaded('feedbacksCount'))
            $this->load('feedbacksCount');
        $related = $this->getRelation('feedbacksCount');
        return ($related) ? (int) $related->aggregate : 0;
    }

    /**
     *
     * Count number of posts belongs to this user
     *
     * @return mixed
     */
    public function reviewsCount()
    {
        return $this->hasOne('App\ProductReview')
            ->selectRaw('product_id, count(*) as aggregate')
            ->groupBy('product_id');
    }
    /**
     *
     * postsCount attribute to count number of post belongs to this user
     *
     * @return int
     */
    public function getReviewsCountAttribute()
    {
        if (!$this->relationLoaded('reviewsCount'))
            $this->load('reviewsCount');
        $related = $this->getRelation('reviewsCount');
        return ($related) ? (int) $related->aggregate : 0;
    }

    public function scopeSearchInName($query, $term)
    {
        return $query->where('name', 'like', "%{$term}%");
    }

    /**
     * @param $query
     * @param $status
     * @return mixed
     */
    public function scopeHasStatus($query, $status)
    {
        if(is_string($status))
            $status = ProductStatus::getStatusIdByName($status);

        if(!$status)
            return;

        return $query->where('status_id', '=', $status);
    }

    public function scopeHasCategory($query, $category)
    {
        return $query->where('category_id', '=', $category);
    }

    public function disable()
    {
        $this->status_id = ProductStatus::getStatusIdByName('disabled');
        return $this->save();
    }

    public function enable()
    {
        $this->status_id = ProductStatus::getStatusIdByName('outofstock');
        return $this->save();
    }
}
