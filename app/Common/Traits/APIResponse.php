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
	protected function success($data)
	{
		$response = [
			'message' => 'success',
			'status_code' => 200,
			'data' => $data
		];

		return response()->json($response, $response['status_code']);
	}

	/**
	 * @param $data
	 * @return JSON|Mixed
	 */
	protected function notFound($data)
	{
		$response = [
			'message' => 'not found',
			'status_code' => 404,
			'data' => $data
		];

		return response()->json($response, $response['status_code']);
	}
}