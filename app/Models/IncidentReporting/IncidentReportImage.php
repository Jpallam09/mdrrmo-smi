<?php
namespace App\Models\IncidentReporting;

use App\Models\IncidentReporting\IncidentReportUser;
use Illuminate\Database\Eloquent\Model;

class IncidentReportImage extends Model
{
    /**
     * The attributes that are mass assignable.
     * These fields can be safely set using create() or fill().
     */
    protected $fillable = [
        'incident_report_user_id',  // Foreign key linking to the incident report
        'file_path',               // Storage path of the uploaded image
        'image_name',               // Original filename of the uploaded image
        'image_size',               // Size of the image in bytes (optional for future use)
        'image_type',               // MIME type of the image (e.g., image/png)
    ];

    /**
     * Define the relationship to the parent incident report.
     *
     * This means each image is associated with one specific incident report.
     * The foreign key used is 'incident_report_user_id'.
     */
    public function report()
    {
        return $this->belongsTo(IncidentReportUser::class, 'incident_report_user_id');
    }
}
