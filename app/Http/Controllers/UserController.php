<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public $response;
    public function __construct(){
        $this->response = new ResponseHelper();
    }
	
	//tambah
    public function register(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'username' => 'required',
			'password' => 'required|string|min:6',
			'role' => 'required',
			'id_outlet' => 'required' 
            
		]);

		if($validator->fails()){
            return $this->response->errorResponse($validator->errors());
		}

		$user = new User();
		$user->name 	= $request->name;
		$user->username = $request->username;
		$user->password = Hash::make($request->password);
		$user->role 	= $request->role;
		$user->id_outlet = $request->id_outlet;

		$user->save();

		$token = JWTAuth::fromUser($user);

        $data = User::where('username','=', $request->username)->first();
        return $this->response->successResponseData('Data user berhasil ditambahkan', $data);
	}
    
    public function login(Request $request)
    {
		$credentials = $request->only('username', 'password');

		try {
			if(!$token = JWTAuth::attempt($credentials)){
                return $this->response->errorResponse('Invalid username and password');
			}
		} catch(JWTException $e){
            return $this->response->errorResponse('Generate Token Failed');
		}

		$user = JWTAuth::user();

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'token' => $token,
			'user' => $user
        ]);
	}

	public function loginCheck(){
		try {
			if(!$user = JWTAuth::parseToken()->authenticate()){
				return $this->response->errorResponse('Invalid token!');
			}
		} catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e){
			return $this->response->errorResponse('Token expired!');
		} catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
			return $this->response->errorResponse('Invalid token!');
		} catch (Tymon\JWTAuth\Exceptions\JWTException $e){
			return $this->response->errorResponse('Token absent!');
		}

		return $this->response->successResponseData('Authentication success!', $user);
	}

	public function getUser()
	{
		$user = JWTAuth::user();
		return response()->json($user);
	}

    public function logout(Request $request)
    {
        if(JWTAuth::invalidate(JWTAuth::getToken())) {
            return $this->response->successResponse('You are logged out');
        } else {
            return $this->response->errorResponse('Logged out failed');
        }
    }
}

/* Jika outlet di relasikan dengan user maka perlu
'id_outlet' => 'required' 
$user->id_outlet = $request->id_outlet;