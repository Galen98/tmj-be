<?php

namespace App\Interfaces\Tracking;

interface UserAnalyticsInterface
{
    public function trackUserActivity($data);
    public function getAllUserActivities($limit = 10);
    public function getUserActivityById($id);
    public function filterByDateRange($startDate, $endDate, $limit = 10);
    //counting total user activities
    public function countTotalUserActivitiesToday();
    public function countTotalUserActivitiesThisWeek();
    public function countTotalUserActivitiesTotal();
    public function countTotalUserActivitiesThisMonth();
    public function countTotalUserActivitiesRange($startDate, $endDate);
    // most visited pages and filter
    public function getMostVisitedPages($limit = 10);
    public function getMostVisitedPagesByDateRange($startDate, $endDate);
    //tracking location
    public function trackUserLocation($data);
    public function getAllUserLocations($limit = 10);
}
