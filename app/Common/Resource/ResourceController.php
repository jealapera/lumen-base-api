<?php

namespace App\Common\Resource;

use App\Common\BaseModelResource;
use App\Common\Traits\APIResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

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
	 * @return Newly created record of data in JSON response
	 * @throws object(Illuminate\Database\QueryException)
	 */
	public function store(Request $request)
	{
		if($validator = $this->validateRequest($request->all(), $this->model()->rules))
        {
            return $this->validationError($validator);
        }
        else
        {
            $create = $this->resource->create($request->all());
            if($errorInfo = $create->errorInfo)
            {
            	$response =  $this->error(new ResourceException(ResourceException::CREATE_ERROR));
            	$response = $response->original;
            	$response['error_info'] = $errorInfo;
            }
            else
            {
            	$response = $this->success($create);
            }
            
            return $response;
        }
	}

	/**
	 * Retrieves all data [With Pagination]
	 * 
	 * @param Request $request
	 * @return Array of data in JSON response
	 */
	public function index(Request $request)
	{
		$recordsPerPage = $request->get('per_page');
        $response = ($recordsPerPage) ? $this->resource->paginate($recordsPerPage) : $this->resource->getAll();

		return $this->success($response);
	}

	/**
	 * Retrieves a specific data by id; However, if no result is found, an exception will be thrown.
	 * 
	 * @param $id
	 * @return Object in JSON response
	 * @throws Illuminate\Database\Eloquent\ModelNotFoundException
	 */
	public function show($id)
	{
		return $this->success($this->resource->getById($id));
	}

	/**
	 * Updates an existing record of data by id
	 * 
	 * @param $id
	 * @param Request $request
	 * @return Updated existing record of data in JSON response
	 * @throws Illuminate\Database\Eloquent\ModelNotFoundException
	 */
	public function update($id, Request $request)
	{
		// Retrieves the first result of the query; However, if no result is found, an exception will be thrown.
		$this->resource->getById($id);

		if($validator = $this->validateRequest($request->all(), $this->model()->rules))
        {   
            return $this->validationError($validator);
        }
        else
        {
            $update = $this->resource->update($id, $request->all());

            if($errorInfo = $update->errorInfo)
            {
            	$response =  $this->error(new ResourceException(ResourceException::UPDATE_ERROR));
            	$response = $response->original;
            	$response['error_info'] = $errorInfo;
            }
            else
            {
            	$response = $this->success($update);
            }

            return $response;
        }
	}

	/**
	 * Deletes a specific data by id; However, if no result is found, an exception will be thrown.
	 * 
	 * @param $id
	 * @return Boolean in JSON Response
	 * @throws Illuminate\Database\Eloquent\ModelNotFoundException
	 */
	public function destroy($id)
	{
		// Retrieves the first result of the query; However, if no result is found, an exception will be thrown.
		$this->resource->getById($id);

		return $this->success($this->resource->delete($id));
	}

    /**
     * Validates all data from the request
     * 
     * @param $data
     * @param $rules
     * @return object(Illuminate\Validation\Validator)
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