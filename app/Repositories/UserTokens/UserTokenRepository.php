<?php

namespace App\Repositories\UserTokens;

use App\Models\UserToken;

class UserTokenRepository
{
    public function create(
        array $data
    ): UserToken {

        return UserToken::create(
            $data
        );
    }


    public function findByToken(
        string $token
    ): ?UserToken {

        return UserToken::where(
            'token',
            $token
        )
        ->where(
            'status',
            true
        )
        ->first();
    }
}
