<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'category';

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
    public function category()
    {
        return $this->belongsTo('App\Category', 'parent_id', 'id');
    }

    /**
     *
     * A category can be parent of many other categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany('App\Category', 'parent_id', 'id');
    }

    /**
     *
     * A category has many posts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    /**
     *
     * Count number of posts belongs to this category
     *
     * @return mixed
     */
    public function postsCount()
    {
        return $this->hasOne('App\Post')
            ->selectRaw('category_id, count(*) as aggregate')
            ->groupBy('category_id');
    }

    /**
     *
     * postsCount attribute to count number of post belongs to this category
     *
     * @return int
     */
    public function getPostsCountAttribute()
    {
        if (!$this->relationLoaded('postsCount'))
            $this->load('postsCount');
        $related = $this->getRelation('postsCount');
        return ($related) ? (int) $related->aggregate : 0;
    }
}

