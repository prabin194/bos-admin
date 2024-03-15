<?php

namespace App\Http\Controllers\API;

use App\Actions\Auth\CreateUserAccountAction;
use App\Actions\Auth\CreateUserAction;
use App\Actions\Auth\GetLoginAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserRegistrationRequest;
use App\Models\User;
use App\Models\UserAccount;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{

    /**
     * @param UserLoginRequest $request
     * @return JsonResponse
     */
    public function login(UserLoginRequest $request): JsonResponse
    {
        try {
            return (new GetLoginAction())->execute($request);
        } catch (\Exception $e) {
            \Log::error('Login error: ' . $e->getMessage());

            return response()->json([
                'message' => 'An error occurred during login. Please try again later.'
            ], 500);
        }
    }


    /**
     * @param UserRegistrationRequest $request
     * @return JsonResponse
     */
    public function register(UserRegistrationRequest $request): JsonResponse
    {
        try {
            $user = User::query()->where('email', $request->email)->first();

            if (!$user) {
                $user = (new CreateUserAction())->execute($request);
            }

            $user_account = UserAccount::query()->where('user_id', $user->uid)->where('domain', $request->domain)->first();

            if ($user_account) {
                return response()->json([
                    'error' => "Oops! It seems like this email is already in use. Please log in with this email to access your account.",
                    'success' => false
                ]);
            }

            (new CreateUserAccountAction())->execute($user, $request);

            $tokenResult = $user->createToken($request->domain . 'MMF Token');
            $token = $tokenResult->plainTextToken;

            return response()->json(['message' => 'Successfully created user!', 'accessToken' => $token], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}
