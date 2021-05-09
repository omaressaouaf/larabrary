<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function getUnreadNotificationsCount()
    {
        $user = User::find(auth()->id());
        return $user->unreadNotifications()->count();
    }

    public function getUnreadNotifications()
    {
        $user = User::find(auth()->id());
        $unreadNotifications = $user->unreadNotifications;
        $user->notifications()->delete();
        return $unreadNotifications;
    }

}
