<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewReportNotification extends Notification
{
    use Queueable;

    protected $report;

    /**
     * Create a new notification instance.
     *
     * @param  mixed  $report  The report model or data array
     */
    public function __construct($report)
    {
        $this->report = $report;
    }

    /**
     * Define which channels the notification should be sent through.
     * For now, only database to avoid sending real emails/SMS during testing.
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Store the notification in the database.
     * The returned array will be saved as JSON in the `data` column.
     */
    public function toDatabase($notifiable)
    {
        return [
            'report_id' => $this->report->id,
            'title' => 'New Report Submitted',
            'message' => 'titled: ' . $this->report->report_title . '"',
            'submitted_by' => $this->report->user_name ?? 'Anonymous',
            'created_at' => $this->report->created_at->toDateTimeString(),
        ];
    }

    /**
     * Optional: Used if we want to broadcast or transform this notification
     * into an array for other channels in the future.
     */
    public function toArray($notifiable)
    {
        return $this->toDatabase($notifiable);
    }
}
