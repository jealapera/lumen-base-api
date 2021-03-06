<?php

namespace App\Http\Controllers;

use App\User;
use App\Common\Traits\APIResponse;
use App\Exceptions\AuthException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;

class AuthController extends BaseController 
{
    use APIResponse;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request) 
    {
        $this->request = $request;
    }

    /**
     * Create a new token.
     * 
     * @param  \App\User   $user
     * @return string
     */
    protected function jwt(User $user) 
    {
        $payload = [ 
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued. 
            'exp' => time() + 60*60 // Expiration time
        ];
        
        // As you can see we are passing `JWT_SECRET` as the second parameter that will 
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    }

    /**
     * Authenticate a user and return the token if the provided credentials are correct.
     * 
     * @param \App\User $user 
     * @return mixed
     */
    public function authenticate(User $user) 
    {
        $this->validate($this->request, [
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        // Find the user by email
        $user = User::where('email', $this->request->input('email'))->first();
        
        if(!$user) 
        {
            return $this->error(new AuthException(AuthException::EMAIL_NOT_FOUND));
        }

        // Verify the password and generate the token
        if(Hash::check($this->request->input('password'), $user->password)) 
        {
            $data = [
                'email' => $user->email,
                'type' => $user->type,
                'token' => $this->jwt($user)
            ];

            return $this->success($data);
        }

        // Bad Request Response
        return $this->error(new AuthException(AuthException::INVALID_CREDENTIALS));
    }
}