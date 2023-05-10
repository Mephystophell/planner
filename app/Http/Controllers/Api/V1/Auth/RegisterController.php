<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterUsersRequest;
use App\Models\Roles;
use App\Models\User;

class RegisterController extends Controller
{

    /**
     * @param RegisterUsersRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function __invoke(RegisterUsersRequest $request)
    {

        $isRegistered = User::query()->where('email',$request->get('email'))->first();

        if (empty($isRegistered)) {

            $user = User::query()->create(
                [
                    'email' => $request->get('email'),
                    'name' => $request->get('name'),
                    'password' => bcrypt($request->get('password')),
                    'remember_token' => self::generateToken(),
                    'role_id' => Roles::ROLE_USER,
                ]
            );

            $response = http_response_code();
            $success['token'] = $user->createToken('Planner')->accessToken;

            return response()->json(["data" => ['success' => $success, 'user' => $user],'response_code' => $response]);

        } else {

            return response()->json(['error' => 'Email already exist'], 401);

        }

    }

    /**
     * {@inheritdoc}
     */
    public static function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }

}
