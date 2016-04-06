<?php
/**
 * Created by PhpStorm.
 * User: Pham Van Hien
 * Date: 12/1/2015
 * Time: 8:21 PM
 */

namespace App;



use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * @var string
     */
    protected $table = 'comment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'content'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * @param $query
     * @param $class
     * @return mixed
     */
    public function scopeBelongToCommentable($query, $class)
    {
        return $query->where('commentable_type', '=', $class);
    }


    /**
     * @param $query
     * @return mixed
     */
    public function scopeBelongToPost($query)
    {
        return $this->belongToCommentable(\App\Post::class);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeBelongToProduct($query)
    {
        return $this->belongToCommentable(\App\Product::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo('App\CommentStatus', 'status_id', 'id');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotSpam($query)
    {
        return $query->where('spam', '=', false);
    }

    /**
     * @param $query
     * @param $status
     * @return mixed
     */
    public function scopeHasStatus($query, $status)
    {
        if(is_string($status))
            $status = CommentStatus::getStatusByName($status);

        return $query->where('status_id', '=', $status);
    }

    /**
     * @param $query
     * @param $term
     */
    public function scopeOrContentContains($query, $term)
    {
        return $query->orWhere('content', 'like', '%'. $term . '%');
    }


    /**
     * @param Builder $query
     * @param $term
     * @return Builder|static
     */
    public function scopeSearchByTerm($query, $term)
    {
        // @TODO search by user not working
        return $query->orWhereHas('user', function($query) use($term) {
            $query->searchByTerm($term);
        })->orContentContains($term);
    }

    /**
     * @param $name
     * @return bool
     */
    public function isStatus($name)
    {
        return $this->status_id == CommentStatus::getStatusByName($name);
    }

    /**
     * @return bool
     */
    public function markAsSpam()
    {
        $this->spam = true;
        return $this->save();
    }

    /**
     * @return bool
     */
    public function markAsNotSpam()
    {
        $this->spam = false;
        return $this->save();
    }
}
