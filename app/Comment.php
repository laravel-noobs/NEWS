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

    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo('App\CommentStatus', 'status_id', 'id');
    }

    public function scopeNotSpam($query)
    {
        return $query->where('spam', '=', false);
    }

    public function scopeHasStatus($query, $status)
    {
        if(is_string($status))
            $status = CommentStatus::getStatusByName($status);

        return $query->where('status_id', '=', $status);
    }

    public function scopeOrContentContains($query, $term)
    {
        $query->orwhere('content', 'like', '%'. $term . '%');
    }

    public function scopeSearchByTerm(Builder $query, $term)
    {
        $query->orWhereHas('user', function($query) use($term) {
            $query->searchByTerm($term);
        });
        $query->orContentContains($term);
    }

    public function isStatus($name)
    {
        return $this->status_id == CommentStatus::getStatusByName($name);
    }

    public function markAsSpam()
    {
        $this->spam = true;
        return $this->save();
    }

    public function markAsNotSpam()
    {
        $this->spam = false;
        return $this->save();
    }
}
