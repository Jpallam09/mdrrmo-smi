<?php

namespace App\Models\IncidentReporting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\IncidentReporting\DeleteRequest
 * @property \Illuminate\Support\Carbon|null $reviewed_at
 * @property int $id
 * @property int $user_id
 * @property int $delete_report_id
 * @property string $reason
 * @property string $status
 * @property Carbon $requested_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\IncidentReporting\IncidentReportUser $report
 * @property int|null $reviewed_by
 */
class DeleteRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'delete_report_id',
        'user_name',
        'report_title',
        'report_date',
        'report_type',
        'report_description',
        'requested_image',
        'reason',
        'status',
        'requested_at',
        'reviewed_at',
    ];
    protected $casts = [
        'requested_image' => 'array',
        'requested_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function report()
    {
        return $this->belongsTo(\App\Models\IncidentReporting\IncidentReportUser::class, 'delete_report_id');
    }
}
