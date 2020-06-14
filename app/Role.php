<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
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
     * The relationship permissions.
     *
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
    
    /**
     * The relationship users.
     *
     */
	public function users()
	{
		return $this->belongsToMany(User::class);
    }

    /**
     * The function for attach permission.
     *
     */
    public function addPermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->first();
        }

        return $this->permissions()->attach($permission);
    }

    /**
     * The function for detach permission.
     *
     */
    public function removePermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->first();
        }

        return $this->permissions()->detach($permission);
    }

    /**
     * The function to check permission.
     *
     */
	public function hasPermissionTo($permission): bool
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->first();
        }

        return $this->permissions->contains('id', $permission->id);
    }
}
