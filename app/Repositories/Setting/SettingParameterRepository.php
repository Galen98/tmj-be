<?php

namespace App\Repositories\Setting;

use App\Models\Setting\SettingParameterModel;

class SettingParameterRepository implements \App\Interfaces\Setting\SettingParameterInterface
{
    public function getAllParameters()
    {
        return SettingParameterModel::all();
    }

    public function getParametersByKey($key)
    {
        return SettingParameterModel::where('key', $key)->first();
    }

    public function updateParameter($key, $data)
    {
        return SettingParameterModel::where('key', $key)->update($data);
    }

    public function searchParametersByKey($key)
    {
        return SettingParameterModel::where('key', 'like', '%' . $key . '%')->get();
    }
}
