<?php

namespace App\Http\Controllers;

use App\User;
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

    /**
     * Retrieves all todos by id of the user
     * 
     * @param $id
     * @return Eloquent Collection in JSON Response
     */
    public function getUserTodosList($id)
    {
        return $this->success($this->model()->getUserTodosList($id));
    }
}