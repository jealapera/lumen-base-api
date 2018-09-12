<?php 

namespace App\Common\Traits;

trait APIResponse 
{
	/**
     * @param Exception $exception
     * @return JSON Response
     */
    protected function error($exception)
    {
        if($exception)
        {
            $response = [
				'message' => $exception->getMessage(),
				'status_code' => $exception->getStatusCode()
			];
        }

        return response()->json(['error' => $response]);
    }

	/**
	 * @param $data
	 * @param $message = null
	 * @return JSON Response
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
	 * @return JSON Response
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
	 * @return JSON Response
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