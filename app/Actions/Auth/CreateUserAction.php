<?php

namespace App\Actions\Auth;

use App\Models\User;
use Ramsey\Uuid\Uuid;

class CreateUserAction
{
    /**
     * @param $request
     * @return mixed
     */
    public function execute($request): mixed
    {
        return User::create([
            'uid' => Uuid::uuid4()->toString(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
        ]);
    }
}
