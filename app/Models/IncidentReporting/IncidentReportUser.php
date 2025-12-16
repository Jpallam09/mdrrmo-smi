<?php

namespace App\Models\IncidentReporting;

use App\Models\User;
use App\Models\IncidentReporting\IncidentReportImage;
use Illuminate\Database\Eloquent\Model;
use App\Models\FeedbackComment;
use Laravel\Scout\Searchable;
use Illuminate\Support\Facades\DB;


class IncidentReportUser extends Model
{
    use Searchable;

    public function toSearchableArray(): array
    {
        return [
            'report_title'       => $this->report_title,
            'report_description' => $this->report_description,
            'report_type'        => $this->report_type,
            'user_name'          => $this->user_name,
            'report_status'      => $this->report_status,
        ];
    }
    /**
     * The attributes that are mass assignable.
     */

    // Report types
    const TYPE_SAFETY       = 'Safety';
    const TYPE_SECURITY     = 'Security';
    const TYPE_OPERATIONAL  = 'Operational';
    const TYPE_ENVIRONMENT  = 'Environmental';
    public static $types = [
        self::TYPE_SAFETY,
        self::TYPE_SECURITY,
        self::TYPE_OPERATIONAL,
        self::TYPE_ENVIRONMENT,
    ];

    // Report statuses
    const STATUS_PENDING     = 'pending';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_SUCCESS     = 'success';
    const STATUS_CANCELED    = 'canceled';

    public static $statuses = [
        self::STATUS_PENDING,
        self::STATUS_IN_PROGRESS,
        self::STATUS_SUCCESS,
        self::STATUS_CANCELED,
    ];

    protected $fillable = [
        'user_name',
        'report_title',
        'report_date',
        'report_type',
        'report_description',
        'report_status',
        'user_id',
    ];

    protected $casts = [
        'requested_image' => 'array',
    ];

        protected static function booted()
    {
        static::deleting(function ($report) {
            // Delete all notifications that reference this report
            DB::table('notifications')
                ->where('data', 'like', '%"report_id":'.$report->id.'%')
                ->delete();
        });
    }

    // Check report status
    public function isPending(): bool
    {
        return $this->report_status === self::STATUS_PENDING;
    }

    public function isSuccess(): bool
    {
        return $this->report_status === self::STATUS_SUCCESS;
    }

    public function isCanceled(): bool
    {
        return $this->report_status === self::STATUS_CANCELED;
    }

    /**
     * Return user-friendly readable status.
     */
    public function readableStatus(): string
    {
        return match ($this->report_status) {
            self::STATUS_SUCCESS => 'Successful',
            self::STATUS_CANCELED => 'Unsuccessful',
            self::STATUS_PENDING => 'Pending',
            self::STATUS_IN_PROGRESS => 'In Progress',
            default => ucfirst($this->report_status),
        };
    }

    // Relationships
    public function images()
    {
        return $this->hasMany(IncidentReportImage::class, 'incident_report_user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function editRequest()
    {
        return $this->hasOne(EditRequest::class, 'edit_report_id');
    }

    public function deleteRequest()
    {
        return $this->hasOne(DeleteRequest::class, 'delete_report_id');
    }

    public function staffLocations()
    {
        return $this->hasMany(StaffLocation::class, 'report_id');
    }

    public function feedbackComments()
    {
        return $this->hasMany(FeedbackComment::class, 'report_id');
    }
}
