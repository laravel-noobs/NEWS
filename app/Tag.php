<?php
/**
 * Created by PhpStorm.
 * User: Pham Van Hien
 * Date: 12/1/2015
 * Time: 10:07 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tag';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug'];

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->morphedByMany('App\Post', 'taggable', 'taggable', 'taggable_id', 'tag_id');
    }

    /**
     * Count number of post have this tag
     *
     * @return mixed
     */
    public function postsCount()
    {
        return $this->belongsToMany('App\Post')->selectRaw('count(post.id) as aggregate')->groupBy('tag_id');
    }

    /**
     * Count number of post have this tag
     *
     * @return int
     */
    public function getPostsCountAttribute()
    {
        if (!$this->relationLoaded('postsCount'))
            $this->load('postsCount');
        $related = $this->getRelation('postsCount')->first();
        return ($related) ? (int) $related->aggregate : 0;
    }
}