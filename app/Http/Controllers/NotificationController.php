<?php

namespace App\Http\Controllers;

use App\Traits\BreadcrumbTrait;
use App\Traits\NotificationTrait;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use BreadcrumbTrait, NotificationTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // page title and breadcrumbs
        $breadcrumbs = $this->getPagebreadcrumbs("User Notifications", "Notifications", "List");
        view()->share('breadcrumbs', $breadcrumbs);

        return view('notifications.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function getNotifications()
    {
        $notificationArray = [];
        $notifications = auth()->user()->notifications()->get();
        $notificationDetails = $this->getNotificationDetails($notifications);

        if(count($notificationDetails) > 0) {
            foreach($notificationDetails as $key => $noti) {

                $message = "";
                $message .= '<div class="media">';
                $message .= '<div class="media-body align-self-center ms-2 text-truncate">';
                $message .= '<h6 class="my-0 fw-normal text-dark">';
                $message .= $noti['title'];
                $message .= '</h6>';
                $message .= '<small class="text-muted mb-0">';
                $message .= $noti['message'];
                $message .= '</small>';
                $message .= '</div>';
                $message .= '</div>';

                $notificationArray[] = [
                    'id' => $noti['id'], 
                    'message' => $message,
                    'is_read' => $noti['isRead'],
                    'date' => $noti['date']
                ];
            }
        }

        return json_encode($notificationArray);
    }

    /**
     * Update the specified resource in storage.
     */
    public function readAllNotifications()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return redirect()->route('notifications')->with('success', 'Your all notifications are mark as read now.');
    }
}












