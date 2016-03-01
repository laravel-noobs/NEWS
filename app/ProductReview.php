<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_review';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'content', 'rate'];

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function scopeHasChecked($query)
    {
        return $query->where('checked', '=', true);
    }

    public function scopeHasNotChecked($query)
    {
        return $query->where('checked', '=', false);
    }

    public function scopeSearchByTerm($query, $term)
    {
        // @TODO
        return $query->where('content', 'like', "%{$term}%");
    }

    public function check()
    {
        $this->checked = true;
        return $this->save();
    }
}
