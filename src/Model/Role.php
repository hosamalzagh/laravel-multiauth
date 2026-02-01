<?php

namespace CobraProjects\Multiauth\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use CobraProjects\Multiauth\Database\Factories\RoleFactory;

class Role extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return RoleFactory::new();
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($role) {
            if ($role->admins()->count() > 0) {
                throw new \Exception('Can not delete, Role is assigned to Admins.');
            }
        });
    }

    protected $fillable = ['name'];

    public function admins()
    {
        return $this->belongsToMany(Admin::class);
    }

    public function permissions()
    {
        $permissionModel = config('multiauth.models.permission');
        return $this->belongsToMany($permissionModel);
    }

    public function addPermission($permission_ids)
    {
        $this->permissions()->attach($permission_ids);
    }

    public function removePermission($permission_ids)
    {
        $this->permissions()->detach($permission_ids);
    }

    public function syncPermissions($permission_ids)
    {
        $this->permissions()->sync($permission_ids);
    }

    public function hasPermission($permission)
    {
        if (is_numeric($permission)) {
            return $this->permissions->contains('id', $permission);
        }
        return $this->permissions->contains('name', $permission);
    }

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }
}
