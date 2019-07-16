<?php

namespace App;

use Redis;
use App\Entities\Learning;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Notifiable, Learning, Billable;

    protected $with = ['subscriptions'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'confirm_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Check User is confirmed email after registeration
     *
     * @return  boolean
     */
    public function isConfirmed()
    {
        return $this->confirm_token == null;
    }

    /**
     * Confirm user email
     *
     * @return  void
     */
    public function confirm()
    {
        $this->confirm_token = null;
        $this->save();
    }

    /**
     * Check if Admin
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return in_array($this->email, config('sgcast.administrators'));
    }

    public function getRouteKeyName() {
        return 'username';
    }
}
