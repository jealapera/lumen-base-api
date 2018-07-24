<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class SampleException extends HttpException
{
    const SAMPLE_VAR = 'This is just a sample.';

    public function __construct($errorType)
    {        
        $statusCode = 422;        
        
        switch($errorType) 
        {            
            case self::SAMPLE_VAR:
                $statusCode = 422;
                break;
        }

        parent::__construct($statusCode, $errorType);
    }
}
