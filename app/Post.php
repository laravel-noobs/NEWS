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

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public static function publishPostsAsScheduled()
    {
        $affected = static::shouldBePublished()
            ->publish();
        return is_numeric($affected) ? $affected : 0;
    }

    public function scopePublish($query)
    {
        return $query->update(['published' => true]);
    }
    public function scopePublished($query)
    {
        return $query->where('published', '=', true);
    }
    public function scopeNotPublished($query)
    {
        return $query->where('published', '=', false);
    }
    public function scopeOnScheduled($query)
    {
        return $query->where('published_at', '<=', Carbon::now()->toDateTimeString());
    }
    public function scopeApproved($query)
    {
        return $query->where('status_id', '=', 3);
    }
    public function scopeShouldBePublished($query)
    {
        return $query->notPublished()->onScheduled()->approved();
    }
}