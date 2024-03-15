<?php

namespace App\Actions\Auth;

use App\Models\UserAccount;
use Illuminate\Support\Facades\Hash;

class GetLoginAction
{
    /**
     * @param $request
     * @return mixed
     */
    public function execute($request): mixed
    {
        $credentials = $request->only('email', 'password');

        $user = UserAccount::query()->where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            if (!$this->check_domains($request)) {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }

            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->plainTextToken;

            return response()->json([
                'accessToken' => $token,
                'token_type' => 'Bearer',
            ]);
        }

        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    /**
     * @param $request
     * @return bool
     */
    private function check_domains($request): bool
    {
        $account = UserAccount::query()->where('email', $request->email)->where('domain', $request->domain)->exists();

        if ($account) {
            return true;
        } else {
            return false;
        }
    }
}
