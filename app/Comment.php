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
    protected $fillable = ['content', 'post_id', 'user_id', 'created_at', 'updated_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
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
            $status = self::getStatusByName($status);

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

    private static function getStatusByName($name)
    {
        switch($name)
        {
            case 'pending':
                return 1;
            case 'approved':
                return 2;
            case 'trash':
                return 3;
            default:
                return null;
        }
    }
}
