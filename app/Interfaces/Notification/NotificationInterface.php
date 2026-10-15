<?php

namespace App\Interfaces\Notification;

interface NotificationInterface
{
    // Define the methods that the NotificationModel must implement
    public function createNotification($data);
    public function getAllNotifications();
    public function checkIsRead($id);
    public function countUnreadNotifications();
    public function markAllAsRead();
}
