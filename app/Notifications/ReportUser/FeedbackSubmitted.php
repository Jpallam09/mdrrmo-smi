<?php

namespace App\Notifications\ReportUser;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FeedbackSubmitted extends Notification
{
    use Queueable;

    public $reportId;
    public $userName;
    public $comment;

    public function __construct($reportId, $userName, $comment)
    {
        $this->reportId = $reportId;
        $this->userName = $userName;
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['database']; // Store in notifications table
    }

    public function toArray($notifiable)
    {
        return [
            'report_id' => $this->reportId,
            'user_name' => $this->userName,
            'comment' => $this->comment,
        ];
    }
}
