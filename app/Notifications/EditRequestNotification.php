<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class EditRequestNotification extends Notification
{
    use Queueable;

    protected $editRequest;

    public function __construct($editRequest)
    {
        $this->editRequest = $editRequest;
    }

    public function via($notifiable)
    {
        return ['database']; // or ['database', 'mail'] if you want emails too
    }

    public function toDatabase($notifiable)
    {
        return [
            'report_id' => $this->editRequest->incident_report_id,
            'edit_request_id' => $this->editRequest->id,
            'title' => 'Edit Request Submitted',
            'submitted_by' => $this->editRequest->user->first_name . ' ' . $this->editRequest->user->last_name,
            'message' => 'User requested to edit report #' . $this->editRequest->incident_report_id,
            'requested_at' => $this->editRequest->requested_at->toDateTimeString(),
        ];
    }

    /*
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New Edit Request Submitted')
                    ->line('An edit request was submitted for report #' . $this->editRequest->incident_report_id)
                    ->action('View Edit Request', url('/staff/edit-requests/' . $this->editRequest->id))
                    ->line('Thank you for managing the reports!');
    }
    */

    public function toArray($notifiable)
    {
        return $this->toDatabase($notifiable);
    }
}
