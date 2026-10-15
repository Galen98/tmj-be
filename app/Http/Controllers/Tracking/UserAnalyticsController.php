<?php

namespace App\Http\Controllers\Tracking;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tracking\UserAnalyticsRequest;
use App\Http\Traits\TraitsResponse;
use App\Services\Tracking\UserAnalyticsService;
use Illuminate\Http\Request;

class UserAnalyticsController extends Controller
{
    use TraitsResponse;

    protected UserAnalyticsService $userAnalyticsService;

    public function __construct(UserAnalyticsService $userAnalyticsService)
    {
        $this->userAnalyticsService = $userAnalyticsService;
    }

    public function trackUserActivity(UserAnalyticsRequest $request)
    {
        try {
            $data = $request->validated();
            $this->userAnalyticsService->trackUserActivity($data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to insert user activity');
        }
        return $this->successResponse(null, 'User activity inserted successfully');
    }

    public function getAllUserActivities(Request $request)
    {
        try {
            $limit = $request->get('limit', 10);

            $result = $this->userAnalyticsService->getAllUserActivities($limit);

            return $this->pagination(
                $result['data'],
                $result['total'],
                $result['page'],
                $result['limit']
            );
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to retrieve user activities');
        }
    }

    public function getUserActivitiesByDateRange(Request $request)
    {
        try {
            $startDate = $request->get('start_date');
            $endDate   = $request->get('end_date');
            $limit     = $request->get('limit', 10);

            $result = $this->userAnalyticsService
                ->getUserActivitiesByDateRange($startDate, $endDate, $limit);

            return $this->pagination(
                $result['data'],
                $result['total'],
                $result['page'],
                $result['limit']
            );

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to retrieve user activities');
        }
    }

    public function getUserActivityById($id)
    {
        try {
            $result = $this->userAnalyticsService->getUserActivityById($id);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to retrieve user activities');
        }
        return $this->successResponse($result, 'User activity retrieved successfully');
    }
}
