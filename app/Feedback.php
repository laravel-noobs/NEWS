<?php
/**
 * Created by PhpStorm.
 * User: Pham Van Hien
 * Date: 12/1/2015
 * Time: 9:51 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'feedback';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'content', 'checked', 'created_at', 'updated_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    public $timestamps = false;

    /**
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
    public function feedbackable()
    {
        return $this->morphTo();
    }

    /**
     * @param $query
     */
    public function scopeNotChecked($query)
    {
        $query->where('checked', '=', false);
    }
}