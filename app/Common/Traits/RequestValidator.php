<?php 

namespace App\Common\Traits;

trait RequestValidator 
{
	private $validator;

    /**
     * Constructor
     */
	public function __construct()
	{
		$this->validator = app('validator');
	}

	/**
     * @param $data
     * @param $rules
     * @return string
     */
    protected function validateRequest($data, $rules)
    {
        $validator = $this->validator->make($data, $rules);
        
        if($validator->fails())
        {
            return $validator;
        }
    }
}