<?php

namespace App\Http\Controllers;

use App\Common\Resource\Controllers\ResourceController;
use App\Common\Traits\HashTrait;
use App\Http\Services\UserService;
use Illuminate\Http\Request;

/**
 * Class UserController
 */
class UserController extends ResourceController
{
	use HashTrait;

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
    	$requestData['password'] = $this->encrypt($requestData['password']);

    	return $this->success($this->service()->create($requestData));
    }
}
