<?php

namespace App\Notifications\ReportUser;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class EditRequestStatusNotification extends Notification
{
    use Queueable;

    protected $editRequest;
    protected $status;

    public function __construct($editRequest, $status)
    {
        $this->editRequest = $editRequest;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'edit_request_id' => $this->editRequest->id,
            'title' => 'Edit Request ' . ucfirst($this->status),
            'message' => "Your edit request for report #{$this->editRequest->incident_report_id} has been {$this->status}.",
            'status' => $this->status,
            'reviewed_at' => now()->toDateTimeString(),
        ];
    }

    public function toArray($notifiable)
    {
        return $this->toDatabase($notifiable);
    }
}
