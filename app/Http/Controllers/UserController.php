<?php

namespace App\Http\Controllers;

use App\Common\Resource\Controllers\ResourceController;
use App\Http\Services\UserService;
use Illuminate\Http\Request;

/**
 * Class UserController
 */
class UserController extends ResourceController
{
	/**
	 * @return UserService
	 */
    public function service()
    {
        return new UserService();
    }

    /**
	 * Creates a new record of user
	 * 
	 * @param Request $request
	 */
    public function store(Request $request)
    {
    	$requestData = $request->all();
    	
        if($validator = $this->validateRequest($requestData, $this->service()->model()->rules))
        {   
            return $this->validationError($validator);
        }
        else
        {
            $requestData['password'] = $this->service()->model()->encryptPassword($requestData['password']);

            return $this->success($this->service()->create($requestData));
        }
    }
}
