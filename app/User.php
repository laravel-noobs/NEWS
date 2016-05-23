<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'first_name', 'last_name', 'password', 'verify_token'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @var array
     */
    protected $dates = ['expired_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feedbacks()
    {
        return $this->hasMany('App\Feedback');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany('App\ProductReview', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rates()
    {
        return $this->belongsToMany('App\Post', 'user_rate', 'user_id', 'post_id')->withPivot(['rate']);
    }

    public function deliveryWard()
    {
        return $this->belongsTo('App\Ward', 'delivery_ward_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    /**
     *
     * Count number of posts belongs to this user
     *
     * @return mixed
     */
    public function postsCount()
    {
        return $this->hasOne('App\Post')
            ->selectRaw('user_id, count(*) as aggregate')
            ->groupBy('user_id');
    }

    /**
     *
     * postsCount attribute to count number of post belongs to this user
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

    /**
     *
     * Count number of posts belongs to this user
     *
     * @return mixed
     */
    public function feedbacksCount()
    {
        return $this->hasOne('App\Feedback')
            ->selectRaw('user_id, count(*) as aggregate')
            ->groupBy('user_id');
    }

    /**
     *
     * postsCount attribute to count number of post belongs to this user
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
     * @param $query
     * @return mixed
     */
    public function scopeVerified($query)
    {
        return $query->where('verified', '=', true);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotVerified($query)
    {
        return $query->where('verified', '=', false);
    }
    /**
     * @param $query
     * @return mixed
     */
    public function scopeBanned($query)
    {
        return $query->where('banned', '=', true);
    }

    /**
     * @param $query
     * @param $role_id
     * @return mixed
     */
    public function scopeHasRole($query, $role_id)
    {
        return $query->where('role_id', '=', $role_id);
    }

    /**
     * @param $query
     * @param $term
     * @return mixed
     */
    public function scopeSearchByTerm($query, $term)
    {
        return $query
            ->orwhere('name', 'like', '%' . $term . '%')
            ->orwhere('first_name', 'like', '%' . $term . '%')
            ->orwhere('last_name', 'like', '%' . $term . '%')
            ->orwhere('email', 'like', '%' . $term . '%');
    }
    
    /**
     * @param $query
     * @param $status_name
     * @return mixed
     */
    public function scopeHasStatus($query, $status_name)
    {
        switch($status_name)
        {
            case 'pending':
                return $query->notVerified();
            case 'verified':
                return $query->verified();
            case 'banned':
                return $query->banned();
            default:
                return $query;
        }
    }

    /**
     * @param string $role
     */
    public function assignRole($role)
    {
        $this->role()->save(
            Role::whereName($role)->firstOrFail()
        );
    }

    /**
     * @param array $roles
     * @return bool
     */
    public function hasRole($roles)
    {
        return $roles->contains('name', $this->role->name);
    }

    public function owns($relation)
    {
        return $this->id == $relation->user_id;
    }

    /**
     *
     */
    public function verifyEmail()
    {
        $this->verify_token = null;
        $this->verified = true;

        $this->save();
    }

    /**
     * @param null $expired_at
     */
    public function ban($expired_at = null)
    {
        $this->banned = true;
        $this->expired_at = $expired_at;

        $this->save();
    }

    public function isAdministrator()
    {
        return $this->role_id == Role::getRoleIdByName('administrator');
    }
}
