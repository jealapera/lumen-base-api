<?php 

namespace App\Common\Resource\Events;

class ResourceWasDeleted
{
	/**
	 * @var
	 */
	public $data;

	/**
	 * @param $data
	 */
	public function __construct($data)
	{
		$this->data = $data;
	}
}