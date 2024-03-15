<?php

namespace App\Actions\Auth;

use Ramsey\Uuid\Uuid;

class CreateUserAccountAction
{
    public function execute($user, $request): void
    {
        $user->user_account()->create([
            'uid' => Uuid::uuid4()->toString(),
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'domain' => $request->domain,
        ]);
    }
}
