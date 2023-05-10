<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LoginController extends Controller
{

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(LoginRequest $request)
    {

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {

            /** @var User $user */
            $user = Auth::user();
            $response = http_response_code();
            $success['token'] = $userToken = $user->createToken('MyApp')->accessToken;

            Storage::put('token', $userToken);

            return response()->json(["data" => ['success' => $success, 'user' => $user], 'response_code' => $response]);

        } else {

            return response()->json(['error' => 'Unauthorised'], 401);

        }

    }
}
