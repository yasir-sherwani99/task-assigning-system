<?php

namespace App\Traits;

use Illuminate\Support\Carbon;

trait NotificationTrait
{
    public function getNotificationDetails($notifications)
    {
        $notificationArray = [];
        if(count($notifications) > 0) {
            foreach($notifications as $key => $noti) {
                $data = $noti->data;
                $dateHuman = Carbon::createFromTimeStamp(strtotime($noti->created_at))->diffForHumans();
                $date = Carbon::parse($noti->created_at)->toDayDateTimeString();
                $isRead = $noti->read_at == null ? 0 : 1;

                $notificationArray[] = [
                    'id' => $noti->id,
                    'icon' => $data['icon'],
                    'title' => $data['title'],
                    'message' => $data['message'],
                    'date' => $date,
                    'date_human' => $dateHuman,
                    'isRead' => $isRead 
                ];
            }
        }

        return $notificationArray;
    }
}
