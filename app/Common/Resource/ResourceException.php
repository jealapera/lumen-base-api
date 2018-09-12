<?php

namespace App\Common\Resource;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ResourceException extends HttpException
{
    const CREATE_ERROR = 'Failed to Create';
    const UPDATE_ERROR = 'Failed to Update';

    public function __construct($errorType)
    {
        $statusCode = 422;        
        
        switch($errorType) 
        {            
            case self::CREATE_ERROR:
            case self::UPDATE_ERROR:
                $statusCode = 422;
                break;
        }

        parent::__construct($statusCode, $errorType);
    }
}