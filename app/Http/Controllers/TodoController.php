<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Common\Resource\Controllers\ResourceController;

/**
 * Class UserController
 */
class TodoController extends ResourceController
{
    /**
     * @return User
     */
    public function model()
    {
        return new Todo();
    }
}