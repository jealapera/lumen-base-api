<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Common\Resource\ResourceController;

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
     * Retrieves all todos by user id
     * 
     * @param $userId
     * @return JSON|Mixed
     */
    public function getAllByUserId($userId)
    {
    	return $this->success($this->model()->getAllByUserId($userId));
    }
}