<?php

namespace App\Notifications\ReportUser;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DeleteRequestStatusNotification extends Notification
{
    use Queueable;

    protected $deleteRequest;
    protected $status;

    public function __construct($deleteRequest, $status)
    {
        $this->deleteRequest = $deleteRequest;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'delete_request_id' => $this->deleteRequest->id,
            'title' => 'Delete Request ' . ucfirst($this->status),
            'message' => "Your delete request for report #{$this->deleteRequest->report_id} has been {$this->status}.",
            'status' => $this->status,
            'reviewed_at' => now()->toDateTimeString(),
        ];
    }

    public function toArray($notifiable)
    {
        return $this->toDatabase($notifiable);
    }
}
