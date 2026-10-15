<?php

namespace App\Services\UserTokens;

use App\DTO\UserTokens\UserTokenDTO;
use App\Repositories\UserTokens\UserTokenRepository;
use Illuminate\Support\Str;

class UserTokenService
{
    public function __construct(
        private UserTokenRepository $repository
    ) {
    }


    public function create(): array
    {
        $userToken =
            $this->repository->create([
                'token' =>
                    (string) Str::uuid(),

                'status' =>
                    true,

                'last_seen_at' =>
                    now(),
            ]);


        return (
            new UserTokenDTO(
                $userToken
            )
        )->toArray();
    }
}
