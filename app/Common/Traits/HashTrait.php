<?php 

namespace App\Common\Traits;

trait HashTrait 
{
	private $hash;

	public function __construct()
	{
		$this->hash = app('hash');
	}

	/**
     * @param $data
     * @return string
     */
    protected function encrypt($data)
    {
        return $this->hash->make($data);
    }
}