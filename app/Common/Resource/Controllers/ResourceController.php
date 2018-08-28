<?php

namespace App\Common\Resource\Controllers;

use App\Common\BaseModelResource;
use App\Common\Traits\APIResponse;
use App\Common\Traits\RequestValidator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

use Illuminate\Validation\ValidationException;

/**
 * Class for Basic CRUD
 * Class ResourceController
 */
class ResourceController extends BaseController
{
	use APIResponse;

	/**
     * @var
     */
    protected $resource;

    /**
     * @var
     */
    protected $validator;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->resource = new BaseModelResource($this->model());
        $this->validator = app('validator');
    }

    /**
	 * @return Model
	 */
	public function model()
	{
		return new Model();
	}

	/**
	 * Creates a new record of data
	 * 
	 * @param Request $request
	 * @return JSON|Mixed
	 */
	public function store(Request $request)
	{
		if($validator = $this->validateRequest($request->all(), $this->model()->rules))
        {   
            return $this->validationError($validator);
        }
        else
        {
            return $this->success($this->resource->create($request->all()));
        }
	}

	/**
	 * Retrieves all data [With Pagination]
	 * 
	 * @param Request $request
	 * @return JSON|Mixed
	 */
	public function index(Request $request)
	{
		$recordsPerPage = $request->get('per_page');
        $response = ($recordsPerPage) ? $this->resource->paginate($recordsPerPage) : $this->resource->getAll();

		return $this->success($response);
	}

	/**
	 * Retrieves a specific data by id
	 * 
	 * @param $id
	 * @return JSON|Mixed
	 */
	public function show($id)
	{   
		return $this->success($this->resource->getById($id));
	}

	/**
	 * Updates an existing record by id
	 * 
	 * @param $id
	 * @param Request $request
	 * @return JSON|Mixed
	 */
	public function update($id, Request $request)
	{
		// Find or Fail
		$this->resource->getById($id);

		if($validator = $this->validateRequest($request->all(), $this->model()->rules))
        {   
            return $this->validationError($validator);
        }
        else
        {
            return $this->success($this->resource->update($id, $request->all()));
        }
	}

	/**
	 * Deletes a specific data by id
	 * 
	 * @param $id
	 * @return JSON|Mixed
	 */
	public function destroy($id)
	{
		// Find or Fail
		$this->resource->getById($id);

		return $this->success($this->resource->delete($id));
	}

    /**
     * Validates all data from the request
     * 
     * @param $data
     * @param $rules
     * @return JSON|Mixed
     */
    public function validateRequest($data, $rules)
    {
        $validator = $this->validator->make($data, $rules);
        
        if($validator->fails())
        {
            return $validator;
        }
    }
}