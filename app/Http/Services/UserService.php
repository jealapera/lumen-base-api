<?php 

namespace App\Http\Services;

use App\User;
use App\Common\Resource\Services\ResourceService;

/**
 * Class UserService
 */
class UserService extends ResourceService
{
    /**
     * @return User
     */
    public function model()
    {
        return new User();
    }
}