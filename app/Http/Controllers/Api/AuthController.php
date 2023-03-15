<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['login', 'register']]);
    }


    public function register(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            User::create([
                "name" => $request->name,
                "phone_number" => $request->phone_number,
                "role_id" => $request->role_id,
                "password" => bcrypt($request->password)
            ]);

            $credentials = $request->only(['phone_number', 'password']);

            if (!$token = auth()->attempt($credentials)) {
                return response()->errorJson('Wrong phone number or password', 401);
            }

            $user = \auth()->user();

            $tokenResult = $request->user()->createToken('Personal Access Token');
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->respondWithToken($tokenResult->plainTextToken, $user);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['phone_number', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->errorJson('Wrong phone number or password', 401);
        }

        $user = \auth()->user();

        $tokenResult = $request->user()->createToken('Personal Access Token');

        return $this->respondWithToken($tokenResult->plainTextToken, $user);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->successJson(['message' => 'Successfully logged out']);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $user)
    {
        return response()->successJson([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => $user
        ]);
    }
}
