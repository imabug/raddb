<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Variable casts.
     *
     * @var array
     */
    protected $casts = [
        'is_admin'          => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    /**
     * Returns whether is_admin flag is set or not.
     */
    public function isAdmin()
    {
        return $this->is_admin;
    }
}
