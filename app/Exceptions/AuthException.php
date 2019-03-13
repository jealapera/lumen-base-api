<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthException extends HttpException
{
    const EMAIL_NOT_FOUND = 'Email does not exist.';
    const INVALID_CREDENTIALS = 'Invalid Credentials';

    public function __construct($errorType)
    {
        $statusCode = 400;        
        
        switch($errorType) 
        {            
            case self::INVALID_CREDENTIALS:
            case self::EMAIL_NOT_FOUND:
                $statusCode = 400;
                break;
        }

        parent::__construct($statusCode, $errorType);
    }
}