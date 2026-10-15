<?php

namespace App\Interfaces\Setting;

interface SettingParameterInterface
{
    public function getAllParameters();
    public function getParametersByKey($key);
    public function updateParameter($key, $data);
    public function searchParametersByKey($key);
}
