<?php

namespace App\Models\IncidentReporting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

/**
 * @property int $id
 * @property int $edit_report_id
 * @property int $requested_by
 * @property string|null $requested_title
 * @property string|null $requested_description
 * @property string|null $requested_type
 * @property array|null $requested_image
 * @property string|null $requested_report_date
 * @property string $status
 * @property \Illuminate\Support\Carbon $requested_at
 * @property int|null $reviewed_by
 * @property \Illuminate\Support\Carbon|null $reviewed_at
 *
 * @property-read \App\Models\User $user
 * @property-read \App\Models\User|null $reviewer
 * @property-read \App\Models\IncidentReporting\IncidentReportUser $report
 */

class EditRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'edit_report_id',
        'user_name',
        'reviewed_by',
        'requested_title',
        'requested_description',
        'requested_type',
        'reason',
        'requested_image',
        'requested_report_date',
        'requested_barangay',
        'requested_latitude',
        'requested_longitude',
        'status',
        'requested_at',
        'reviewed_at',
    ];
    // This lets Laravel treat JSON image data as array automatically
    protected $casts = [
        'requested_image' => 'array',
        'requested_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

        // Relationships
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

        public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function report()
    {
        return $this->belongsTo('App\Models\IncidentReporting\IncidentReportUser', 'edit_report_id');
    }
}
