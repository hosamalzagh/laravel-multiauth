<?php

namespace CobraProjects\Multiauth\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use CobraProjects\Multiauth\Database\Factories\AdminFactory;
use CobraProjects\Multiauth\Traits\hasPermissions;
use Illuminate\Foundation\Auth\User as Authenticatable;
use CobraProjects\Multiauth\Notifications\AdminResetPasswordNotification;

class Admin extends Authenticatable
{
    use Notifiable, hasPermissions, HasFactory;

    protected static function newFactory()
    {
        return AdminFactory::new();
    }

    protected $casts = ['active' => 'boolean'];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
