<?php

namespace App\DTO\UserTokens;

use App\DTO\BaseDTO;
use App\Models\UserToken;

class UserTokenDTO extends BaseDTO
{
    public function __construct(
        private UserToken $userToken
    ) {
    }

    public function toArray(): array
    {
        return [
            'userToken' =>
                $this->userToken->token,
        ];
    }
}
