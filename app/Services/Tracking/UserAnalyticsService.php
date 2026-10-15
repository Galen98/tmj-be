<?php

namespace App\Services\Tracking;

use App\DTO\Tracking\UserAnalyticsDTO;
use App\Repositories\Tracking\UserAnalyticsRepository;
use App\Services\BaseService;
use UserActivitiesDTO;

class UserAnalyticsService extends BaseService
{
    protected UserAnalyticsRepository $userAnalyticsRepository;

    public function __construct(UserAnalyticsRepository $userAnalyticsRepository)
    {
        $this->userAnalyticsRepository = $userAnalyticsRepository;
    }

    public function trackUserActivity($data)
    {
        return $this->userAnalyticsRepository->trackUserActivity($data);
    }

    public function getAllUserActivities($limit = 10)
    {
        $track = $this->userAnalyticsRepository->getAllUserActivities($limit);

        $data = collect($track->items())->map(function ($item) {
            return (new UserActivitiesDTO(
                $item->ip_address,
                (int) $item->total_visits,
                $item->last_opened,
                $item->first_opened
            ))->toArray();
        });

        return [
            'data' => $data,
            'total' => $track->total(),
            'page' => $track->currentPage(),
            'limit' => $track->perPage()
        ];
    }

    public function getUserActivityById($id)
    {
        $track = $this->userAnalyticsRepository->getUserActivityById($id);
        return $track->map(function($item){
            return (new UserAnalyticsDTO(
                $item->id,
                $item->user_id,
                $item->page_name,
                $item->link,
                $item->date_opened,
                $item->travel_name,
                json_decode($item->details, true)
            ))->toArray();
        });
    }

    public function getUserActivitiesByDateRange($startDate, $endDate, $limit = 10)
    {
        $track = $this->userAnalyticsRepository
            ->filterByDateRange($startDate, $endDate, $limit);

        $data = collect($track->items())->map(function ($item) {
            return (new UserActivitiesDTO(
                $item->ip_address,
                (int) $item->total_visits,
                $item->last_opened,
                $item->first_opened
            ))->toArray();
        });

        return [
            'data' => $data,
            'total' => $track->total(),
            'page' => $track->currentPage(),
            'limit' => $track->perPage()
        ];
    }

    //user location tracking
}
