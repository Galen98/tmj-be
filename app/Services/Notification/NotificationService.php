<?php

namespace App\Services\Notification;

use App\DTO\Notification\NotificationDTO;
use App\Repositories\Notification\NotificationRepository;
use App\Services\BaseService;

class NotificationService extends BaseService
{
    // Implement the logic for handling notifications here
    protected NotificationRepository $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function sendNotification($data)
    {
        return $this->notificationRepository->createNotification($data);
    }

    public function getAllNotifications()
    {
        $notifications = $this->notificationRepository->getAllNotifications();
        return $notifications->map(function ($item) {
            return (new NotificationDTO(
                $item->id,
                $item->service_name,
                $item->url,
                $item->is_read
            ))->toArray();
        });
    }

    public function checkIsRead($id)
    {
        return $this->notificationRepository->checkIsRead($id);
    }

    public function countUnreadNotifications()
    {
        return $this->notificationRepository->countUnreadNotifications();
    }

    public function markAllAsRead()
    {
        return $this->notificationRepository->markAllAsRead();
    }
}
