<?php

namespace App\Http\Controllers;

use App\User;
use App\Common\Resource\Controllers\ResourceController;
use Illuminate\Http\Request;

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
	 * Creates a new record of user
	 * 
	 * @param Request $request
     * @return 
	 */
    public function store(Request $request)
    {
    	$requestData = $request->all();
    	
        if($validator = $this->validateRequest($requestData, $this->model()->rules))
        {   
            return $this->validationError($validator);
        }
        else
        {
            $requestData['password'] = $this->model()->encryptPassword($requestData['password']);

            return $this->success($this->resource->create($requestData));
        }
    }
}