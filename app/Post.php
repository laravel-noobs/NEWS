<?php
/**
 * Created by PhpStorm.
 * User: Pham Van Hien
 * Date: 12/1/2015
 * Time: 9:58 PM
 */

namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'post';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'slug', 'content', 'category_id', 'published_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * @var array
     */
    protected $dates = ['published_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feedbacks()
    {
        return $this->morphMany('App\Feedback', 'feedbackable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable', 'taggable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rates()
    {
        return $this->belongsToMany('App\User', 'user_rate', 'post_id', 'user_id')->withPivot(['rate']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo('App\PostStatus', 'status_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     *
     * Count number of posts belongs to this user
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
     * postsCount attribute to count number of post belongs to this user
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
     * Count number of feedbacks belongs to this post
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
     * postsCount attribute to count number of feedbacks belongs to this post
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
     * @return int|string
     */
    public static function publishPostsAsScheduled()
    {
        $affected = static::shouldBePublished()
            ->publish();
        return is_numeric($affected) ? $affected : 0;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePublish($query)
    {
        return $query->update(['published' => true]);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('published', '=', true);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotPublished($query)
    {
        return $query->where('published', '=', false);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeOnScheduled($query)
    {
        return $query->where('published_at', '<=', Carbon::now()->toDateTimeString());
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeApproved($query)
    {
        return $query->where('status_id', '=', 3);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeShouldBePublished($query)
    {
        return $query->notPublished()->onScheduled()->approved();
    }

    /**
     * @param $query
     * @param $status
     * @return mixed
     */
    public function scopeHasStatus($query, $status)
    {
        if(is_string($status))
            $status = PostStatus::getStatusIdByName($status);
        return $query->where('status_id', '=', $status);
    }

    /**
     * @param $query
     * @param $category_id
     * @return mixed
     */
    public function scopeHasCategory($query, $category_id)
    {
        return $query->where('category_id', '=', $category_id);
    }

    /**
     * @param $query
     * @param $term
     * @return mixed
     */
    public function scopeHasTitleContains($query, $term)
    {
        return $query->where('title', 'like', '%' . $term . '%');
    }

    /**
     * @param $query
     * @param $user_id
     * @return mixed
     */
    public function scopeOwnedBy($query, $user_id)
    {
        return $query->where('user_id', '=', $user_id);
    }
}