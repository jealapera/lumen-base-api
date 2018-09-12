<?php

namespace App\Http\Controllers;

use App\Common\Resource\ResourceController;
use App\Models\Todo;

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

    /**
     * Retrieves all todos with user
     * 
     * @return Collection in JSON Response
     */
    public function getAllTodosWithUser()
    {
    	return $this->success($this->model()->getAllTodosWithUser());
    }
}