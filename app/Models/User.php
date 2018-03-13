<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Backpack\Base\app\Notifications\ResetPasswordNotification as ResetPasswordNotification;
use Backpack\CRUD\CrudTrait;

class User extends Authenticatable
{

    use Notifiable;
    use CrudTrait; // <----- this

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','profile'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }


    const USER_PROFILE__ADMIN = 'admin';
    const USER_PROFILE__VENDOR = 'vendor';

    public static function getUserProfiles() {
        return array(
            self::USER_PROFILE__ADMIN => trans('app.admin'),
            self::USER_PROFILE__VENDOR => trans('app.vendor')
        );
    }

    public function isAdmin() {
        return $this->profile == User::USER_PROFILE__ADMIN;
    }

    public function isVendor() {
        return $this->profile == User::USER_PROFILE__VENDOR;
    }
}
