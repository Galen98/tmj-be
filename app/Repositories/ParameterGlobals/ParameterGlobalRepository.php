<?php

namespace App\Repositories\ParameterGlobals;

use App\Models\ParameterGlobal;
use Illuminate\Database\Eloquent\Collection;

class ParameterGlobalRepository
{
    public function findPublicByName(string $name): ?ParameterGlobal
    {
        return ParameterGlobal::query()
            ->where('name', $name)
            ->where('is_public', true)
            ->first();
    }

    public function findByName(
        string $name
    ): ?ParameterGlobal {

        return ParameterGlobal::where(
            'name',
            $name
        )->first();
    }


    public function getAll(): Collection
    {
        return ParameterGlobal::orderBy(
            'name'
        )->get();
    }


    public function update(
        ParameterGlobal $parameter,
        ?string $value
    ): ParameterGlobal {

        $parameter->update([
            'value' => $value,
        ]);

        return $parameter->refresh();
    }
}
