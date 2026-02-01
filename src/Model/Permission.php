<?php

namespace CobraProjects\Multiauth\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use CobraProjects\Multiauth\Database\Factories\PermissionFactory;

class Permission extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PermissionFactory::new();
    }
    protected $fillable = ['name', 'parent'];

    public function roles()
    {
        $roleModel = config('multiauth.models.role');
        return $this->belongsToMany($roleModel);
    }

    public function admins()
    {
        $adminModel = config('multiauth.models.admin');
        return $this->belongsToMany($adminModel);
    }
}
