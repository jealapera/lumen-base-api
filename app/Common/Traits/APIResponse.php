<?php 

namespace App\Common\Traits;

trait APIResponse 
{
	/**
     * @param $exception
     * @throws Exception
     */
    protected function error($exception)
    {
        if($exception)
            throw $exception;
    }

	/**
	 * @param $data
	 * @return JSON|Mixed
	 */
	protected function notFound($data, $message = null)
	{
		$response = [
			'message' => ($message) ? $message : "Not Found",
			'status_code' => 404,
			'data' => $data
		];

		return response()->json($response, $response['status_code']);
	}

	/**
	 * @param $data
	 * @return JSON|Mixed
	 */
	protected function success($data)
	{
		$response = [
			'message' => 'Success',
			'status_code' => 200,
			'data' => $data
		];

		return response()->json($response, $response['status_code']);
	}

	/**
	 * @param $validator
	 * @return JSON|Mixed
	 */
	protected function validationError($validator)
	{
		$response = [
            'message' => "The given data is invalid.",
            'status_code' => 400,
            'errors' => $validator->errors()
        ];

		return response()->json($response, $response['status_code']);
	}
}