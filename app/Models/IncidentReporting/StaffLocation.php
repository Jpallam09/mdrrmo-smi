<?php

namespace App\Models\IncidentReporting;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StaffLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'report_id',
        'latitude',
        'longitude',
    ];

    /**
     * Each location belongs to a staff user.
     */
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    /**
     * Each location belongs to an incident report.
     */
    public function report()
    {
        return $this->belongsTo(IncidentReportUser::class, 'report_id');
    }

}
