<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class IncidentReportNotification extends Notification
{
    use Queueable;

    protected $reportId;
    protected $status;
    protected $submittedBy;

    /**
     * Create a new notification instance.
     *
     * @param int $reportId
     * @param string $status
     * @param string|null $submittedBy
     */
    public function __construct(int $reportId, string $status, ?string $submittedBy = null)
    {
        $this->reportId = $reportId;
        $this->status = $status;
        $this->submittedBy = $submittedBy;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['database']; // Only store in DB for now
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'report_id'    => $this->reportId,
            'status'       => $this->status,
            'title'        => $this->status === 'success' ? 'Report is Resolved' : 'Report is Unsuccessful',
            'message'      => $this->status === 'success'
                                ? 'The report has been successfully resolved.'
                                : 'The report has been canceled.',
            'submitted_by' => $this->submittedBy,
        ];
    }
}
