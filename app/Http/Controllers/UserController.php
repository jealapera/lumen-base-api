<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Common\Resource\ResourceController;

/**
 * Class UserController
 */
class UserController extends ResourceController
{
    /**
     * @return User
     */
    public function model()
    {
        return new User();
    }
}