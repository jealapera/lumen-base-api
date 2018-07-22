<?php

namespace App\Common\Resource\Controllers;

use App\Common\Resource\Services\ResourceService;
use App\Common\Traits\APIResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class for Basic CRUD
 * Class ResourceService
 */
class ResourceController extends BaseController
{
	use APIResponse;

	/**
	 * @return ResourceService
	 */
	public function service()
	{
		return new ResourceService();
	}

	/**
	 * Creates a new record of data
	 * 
	 * @param Request $request
	 */
	public function store(Request $request)
	{
		return $this->success($this->service()->create($request->all()));
	}

	/**
	 * Retrieves all data
	 * 
	 * @param Request $request
	 * @return array
	 */
	public function index(Request $request)
	{
		$perPage = $request->get('per_page');
        $response = ($perPage) ? $this->service()->paginate($perPage) : $this->service()->getAll();

		return $this->success($response);
	}

	/**
	 * Retrieves a specific data by id
	 * 
	 * @param $id
	 * @return mixed
	 */
	public function getById($id)
	{   
		if(!$data = $this->service()->getById($id))
        {
            return $this->notFound($data);
        }
        else
        {
            return $this->success($data);
        }
	}

	/**
	 * Updates an existing record by id
	 * 
	 * @param $id
	 * @param Request $request
	 */
	public function update($id, Request $request)
	{
		if(!$data = $this->service()->getById($id))
		{
			return $this->notFound($data);
		}
		else
		{
			return $this->success($this->service()->update($id, $request->all()));
		}
	}

	/**
	 * Deletes a specific data by id
	 * 
	 * @param $id
	 * @return mixed
	 */
	public function destroy($id)
	{
		if(!$data = $this->service()->getById($id))
        {
            return $this->notFound($data);
        }
        else
        {
            return $this->success($this->service()->delete($id));
        }
	}
}