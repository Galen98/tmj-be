<?php

namespace App\Repositories\Notification;

use App\Interfaces\Notification\NotificationInterface;
use App\Models\Notification\NotificationModel;
use Override;

class NotificationRepository implements NotificationInterface
{
    // Implement the methods defined in the NotificationInterface
    public function createNotification($data)
    {
        return NotificationModel::create($data);
    }

    public function getAllNotifications()
    {
        return NotificationModel::where('is_read', false)->get();
    }

    public function checkIsRead($id)
    {
        $notification = NotificationModel::findOrFail($id);

        $notification->update([
            'is_read' => true
        ]);

        return $notification;
    }

    public function countUnreadNotifications()
    {
        return NotificationModel::where('is_read', false)->count();
    }

    public function markAllAsRead()
    {
        return NotificationModel::where('is_read', false)->update(['is_read' => true]);
    }

    // public function getNotif($page, $limit)
    // {
    //     $query = NotificationModel::query();

    //     $total = $query->count();

    //     $data = $query
    //         ->skip(($page - 1) * $limit)
    //         ->take($limit)
    //         ->get();

    //     return [
    //         'data' => $data,
    //         'total' => $total,
    //     ];
    // }
}
