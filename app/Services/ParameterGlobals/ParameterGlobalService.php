<?php

namespace App\Services\ParameterGlobals;

use App\Models\ParameterGlobal;
use App\Repositories\ParameterGlobals\ParameterGlobalRepository;

class ParameterGlobalService
{
    public function __construct(
        private ParameterGlobalRepository $repository
    ) {
    }

    public function getPublicByName(string $name): ?ParameterGlobal
    {
        return $this->repository->findPublicByName($name);
    }

    public function getValue(
        string $name,
        ?string $default = null
    ): ?string {

        $parameter =
            $this->repository
                ->findByName($name);


        return $parameter?->value
            ?? $default;
    }


    public function getAll()
    {
        return $this->repository
            ->getAll();
    }


    public function update(
        ParameterGlobal $parameter,
        ?string $value
    ): ParameterGlobal {

        return $this->repository
            ->update(
                $parameter,
                $value
            );
    }
}
