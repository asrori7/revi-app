<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The relationship roles.
     *
     */
    public function roles()
	{
		return $this->belongsToMany(Role::class);
    }
    
    /**
     * The relationship users.
     *
     */
	public function users()
	{
		return $this->hasManyThrough(User::class, Role::class);
	}

    /**
     * The attributes that should be cast.
     *
     */
	public function setNameAttribute($value)
	{
		if(!empty($value)) $this->attributes['name'] = str_replace(" ", "-", strtolower($value));
	}
}
