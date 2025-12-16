<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DeleteRequestNotification extends Notification
{
    use Queueable;

    protected $deleteRequest;

    public function __construct($deleteRequest)
    {
        $this->deleteRequest = $deleteRequest;
    }

    public function via($notifiable)
    {
        return ['database']; // or ['database', 'mail'] if you want email notifications too
    }

    public function toDatabase($notifiable)
    {
        return [
            'report_id' => $this->deleteRequest->incident_report_id,
            'delete_request_id' => $this->deleteRequest->id,
            'title' => 'Delete Request Submitted',
            'submitted_by' => $this->deleteRequest->user->first_name . ' ' . $this->deleteRequest->user->last_name,
            'message' => 'User requested to delete report #' . $this->deleteRequest->report_id,
            'requested_at' => $this->deleteRequest->requested_at->toDateTimeString(),
        ];
    }

    /*
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New Delete Request Submitted')
                    ->line('A delete request was submitted for report #' . $this->deleteRequest->report_id)
                    ->action('View Delete Request', url('/staff/delete-requests/' . $this->deleteRequest->id))
                    ->line('Thank you for managing the reports!');
    }
    */

    public function toArray($notifiable)
    {
        return $this->toDatabase($notifiable);
    }
}
