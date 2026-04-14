<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class AppNotificationService
{
    public function sendToUser(User $user, string $message): Notification
    {
        return Notification::create([
            'user_id' => $user->id,
            'message' => $message,
            'is_read' => false,
        ]);
    }

    /**
     * @param Collection<int, User>|array<int, User> $users
     */
    public function sendToUsers(iterable $users, string $message): void
    {
        foreach ($users as $user) {
            $this->sendToUser($user, $message);
        }
    }

    public function markAsRead(Notification $notification): void
    {
        $notification->update(['is_read' => true]);
    }

    public function markAllAsRead(User $user): int
    {
        return $user->notifications()->where('is_read', false)->update(['is_read' => true]);
    }
}
