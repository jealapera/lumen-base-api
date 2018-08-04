<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The rules for the validation of the given data.
     *
     * @var array
     */
    public $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed', // Key for Confirmation: password_confirmation
        'type' => 'required'
    ];

    /**
     * @param $password
     * @return string
     */
    public function encryptPassword($password)
    {
        return app('hash')->make($password);
    }
}