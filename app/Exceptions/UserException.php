<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class UserException extends HttpException
{
    const INVALID_CREDENTIALS = 'Invalid Credentials';
    const USER_NOT_FOUND = 'User Not Found';

    public function __construct($errorType)
    {        
        $statusCode = 422;        
        
        switch($errorType) 
        {            
            case self::INVALID_CREDENTIALS:
            case self::USER_NOT_FOUND:
                $statusCode = 422;
                break;
        }

        parent::__construct($statusCode, $errorType);
    }
}
