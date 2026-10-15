<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\SettingParameterRequest;
use App\Http\Traits\TraitsResponse;
use App\Services\Setting\SettingParameterService;
use Exception;
use Illuminate\Http\Request;

class SettingParameterController extends Controller
{
    use TraitsResponse;

    protected SettingParameterService $settingParameterService;

    public function __construct(SettingParameterService $settingParameterService)
    {
        $this->settingParameterService = $settingParameterService;
    }

    public function getAllParameters()
    {
        try {
            $parameters = $this->settingParameterService->getAllParameters();
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to send notification');
        }
        return $this->successResponse($parameters, 'Parameters retrieved successfully');
    }

    public function getParametersByKey($key)
    {
        try {
            $parameters = $this->settingParameterService->getParametersByKey($key);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to send notification');
        }
        return $this->successResponse($parameters, 'Parameters retrieved successfully');
    }

    public function searchParametersByKey($key)
    {
        try {
            $parameters = $this->settingParameterService->searchParametersByKey($key);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to send notification');
        }
        return $this->successResponse($parameters, 'Parameters retrieved successfully');
    }

    public function updateParameter(SettingParameterRequest $request, $key)
    {
        try {
            $data = $request->only(['value', 'description']);
            $parameter = $this->settingParameterService->updateParameter($key, $data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to update parameter');
        }
        return $this->successResponse($parameter, 'Parameter updated successfully');
    }
}
