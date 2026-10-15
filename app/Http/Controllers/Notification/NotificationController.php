<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\NotificationRequest;
use App\Http\Traits\TraitsResponse;
use App\Services\Notification\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use TraitsResponse;

    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function sendNotification(NotificationRequest $request)
    {
        try{
            $data = $request->validated();
            $data['is_read'] = false;
            $notification = $this->notificationService->sendNotification($data);
            return $this->successResponse($notification, 'Notification sent successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to send notification');
        }
    }

    public function getAllNotifications()
    {
        try {
            $notifications = $this->notificationService->getAllNotifications();
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to retrieve notifications');
        }
        return $this->successResponse($notifications, 'Notifications retrieved successfully');
    }

    public function checkIsRead($id)
    {
        try {
            $notification = $this->notificationService->checkIsRead($id);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to check notification status');
        }
        return $this->successResponse($notification, 'Notification status checked successfully');
    }

    public function countUnreadNotifications()
    {
        try {
            $count = $this->notificationService->countUnreadNotifications();
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to count unread notifications');
        }
        return $this->successResponse($count, 'Unread notifications counted successfully');
    }

    public function markAllAsRead()
    {
        try {
            $this->notificationService->markAllAsRead();
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to mark notifications as read');
        }
        return $this->successResponse(null, 'All notifications marked as read successfully');
    }
}
