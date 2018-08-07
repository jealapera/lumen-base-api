<?php

namespace App\Http\Controllers;

use App\User;
use App\Common\Resource\Controllers\ResourceController;
use App\Exceptions\UserException;
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
     * Authentication
     * 
     * @param Request $request
     * @return JSON|Mixed
     */
    public function authenticate(Request $request) 
    {
        $this->validateRequest($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if($user = $this->model()->getByEmail($request->get('email')))
        {
            if($this->model()->checkPassword($request->get('password'), $user->password))
            {
                return $this->success($user);
            }
            else
            {
                return $this->error(new UserException(UserException::INVALID_CREDENTIALS));
            }
        }
        else
        {
            return $this->notFound($user, UserException::USER_NOT_FOUND);
        }
    }

    /**
     * Creates a new record of user
     * 
     * @param Request $request
     * @return JSON|Mixed
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