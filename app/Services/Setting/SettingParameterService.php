<?php

namespace App\Services\Setting;

use App\DTO\Setting\SettingParameter\SettingParameterDTO;
use App\Repositories\Setting\SettingParameterRepository;
use App\Services\BaseService;

class SettingParameterService extends BaseService
{
    protected SettingParameterRepository $settingParameterRepository;

    public function __construct(SettingParameterRepository $settingParameterRepository)
    {
        $this->settingParameterRepository = $settingParameterRepository;
    }

    public function getAllParameters()
    {
        $parameters = $this->settingParameterRepository->getAllParameters();
        return $parameters->map(function ($item){
            return (new SettingParameterDTO(
                $item->id,
                $item->key,
                $item->value,
                $item->description
            ))->toArray();
        });
    }

    public function getParametersByKey($key)
    {
        $parameter = $this->settingParameterRepository->getParametersByKey($key);
        if ($parameter) {
            return $parameter->map(function ($item){
            return (new SettingParameterDTO(
                $item->id,
                $item->key,
                $item->value,
                $item->description
            ))->toArray();
        });
        }
    }

    public function searchParametersByKey($key)
    {
    $parameter = $this->settingParameterRepository->searchParametersByKey($key);
        if ($parameter) {
            return $parameter->map(function ($item){
            return (new SettingParameterDTO(
                $item->id,
                $item->key,
                $item->value,
                $item->description
            ))->toArray();
        });
        }
    }

    public function updateParameter($key, $data)
    {
        return $this->settingParameterRepository->updateParameter($key, $data);
    }
}
