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
    protected $fillable = ['title', 'slug', 'content', 'view', 'status_id', 'category_id', 'published_at',
        'created_at', 'updated_at'];

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
        return $this->hasMany('App\Feedback');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function postStatus()
    {
        return $this->belongsTo('App\PostStatus', 'status_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
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
        return $this->hasOne('App\Comment')
            ->selectRaw('post_id, count(*) as aggregate')
            ->groupBy('post_id');
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
        return $this->hasOne('App\Feedback')
            ->selectRaw('post_id, count(*) as aggregate')
            ->groupBy('post_id');
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
            $status = $this->getStatusByName($status);
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

    public function scopeHasTitleContains($query, $term)
    {
        return $query->where('title', 'like', '%' . $term . '%');
    }

    /**
     * @param $name
     * @return int|null
     */
    public static function getStatusByName($name)
    {
        switch($name)
        {
            case 'pending':
                return 2;
            case 'approved':
                return 3;
            case 'draft':
                return 1;
            case 'trash':
                return 4;
            default:
                return null;
        }
    }
}