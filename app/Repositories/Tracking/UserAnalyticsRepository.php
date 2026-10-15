<?php

namespace App\Repositories\Tracking;

use App\Interfaces\Tracking\UserAnalyticsInterface;
use App\Models\Tracking\UserAnalyticsModel;
use App\Models\Tracking\UserTrackingGeoModel;
use Illuminate\Support\Facades\DB;
use Override;

class UserAnalyticsRepository implements UserAnalyticsInterface
{
    public function trackUserActivity($data)
    {
        return UserAnalyticsModel::create($data);
    }

    #[Override]
    public function getAllUserActivities($limit = 10)
    {
        return UserAnalyticsModel::select(
            'ip_address',
            DB::raw('COUNT(*) as total_visits'),
            DB::raw('MAX(date_opened) as last_opened'),
            DB::raw('MIN(date_opened) as first_opened')
        )
        ->groupBy('ip_address')
        ->orderByDesc('last_opened')
        ->paginate($limit);
    }

    #[Override]
    public function getUserActivityById($id)
    {
        return UserAnalyticsModel::where('ip_address', $id)->get();
    }

    #[Override]
    public function filterByDateRange($startDate, $endDate, $limit = 10)
    {
        return UserAnalyticsModel::select(
                'ip_address',
                DB::raw('COUNT(*) as total_visits'),
                DB::raw('MAX(date_opened) as last_opened'),
                DB::raw('MIN(date_opened) as first_opened')
            )
            ->whereBetween('date_opened', [$startDate, $endDate])
            ->groupBy('ip_address')
            ->orderByDesc('last_opened')
            ->paginate($limit);
    }

    // counting total user activities
    public function countTotalUserActivitiesToday()
    {
        return UserAnalyticsModel::whereDate('date_opened', now()->toDateString())->count();
    }

    public function countTotalUserActivitiesThisWeek()
    {
        return UserAnalyticsModel::whereBetween('date_opened', [now()->startOfWeek(), now()->endOfWeek()])->count();
    }

    public function countTotalUserActivitiesTotal()
    {
        return UserAnalyticsModel::count();
    }

    public function countTotalUserActivitiesThisMonth()
    {
        return UserAnalyticsModel::whereMonth('date_opened', now()->month)->count();
    }

    public function countTotalUserActivitiesRange($startDate, $endDate)
    {
        return UserAnalyticsModel::whereBetween('date_opened', [$startDate, $endDate])->count();
    }

    // most visited pages and filter
    public function getMostVisitedPages($limit = 10)
    {
        return UserAnalyticsModel::select('page_name', DB::raw('COUNT(*) as total_visits'))
            ->groupBy('page_name')
            ->orderByDesc('total_visits')
            ->limit($limit)
            ->get();
    }

    public function getMostVisitedPagesByDateRange($startDate, $endDate)
    {
        return UserAnalyticsModel::select('page_name', DB::raw('COUNT(*) as total_visits'))
            ->whereBetween('date_opened', [$startDate, $endDate])
            ->groupBy('page_name')
            ->orderByDesc('total_visits')
            ->get();
    }

    public function trackUserLocation($data)
    {
        return UserTrackingGeoModel::create($data);
    }

    #[Override]
    public function getAllUserLocations($limit = 10)
    {
        return UserTrackingGeoModel::orderByDesc('date_time_opened')->paginate($limit);
    }
}
