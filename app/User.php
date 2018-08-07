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
     * @var
     */
    private $hash;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->hash = app('hash');
    }

    /**
     * @param $requestPassword
     * @param $storedPassword
     * @return string
     */
    public function checkPassword($requestPassword, $storedPassword)
    {
        return $this->hash->check($requestPassword, $storedPassword);
    }

    /**
     * @param $password
     * @return string
     */
    public function encryptPassword($password)
    {
        return $this->hash->make($password);
    }

    /**
     * Retrieves a specific user by email
     * 
     * @param $email
     * @return Object
     */
    public function getByEmail($email)
    {   
        return $this->where('email', $email)->first();
    }
}