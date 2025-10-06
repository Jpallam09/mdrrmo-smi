<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\IncidentReporting\IncidentReportUser;

class FeedbackComment extends Model
{
    use HasFactory;

    /**
     * -------------------------------------------------------------------------
     * Mass Assignment
     * -------------------------------------------------------------------------
     * 
     * The $fillable property defines which attributes are allowed to be
     * mass-assigned (for example, when calling `FeedbackComment::create([...])`).
     * 
     * Protects against mass-assignment vulnerabilities by explicitly whitelisting
     * fields that can be set via user input.
     */
    protected $fillable = [
        'user_id',// The ID of the user who submitted the feedback
        'report_id',// The ID of the report this feedback is associated with
        'comment',   // The actual text of the feedback
        // Note: 'report_id' is not included here, but can be added if needed
    ];

    /**
     * -------------------------------------------------------------------------
     * RELATIONSHIPS
     * -------------------------------------------------------------------------
     */

    /**
     * Get the user who wrote this feedback comment.
     *
     * - A feedback comment is always linked to exactly **one user**.
     * - This defines the "inverse" side of a one-to-many relationship:
     *   User (1) → FeedbackComment (many).
     *
     * Example usage:
     *   $comment->user;  // returns the User model who wrote this comment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the incident report this feedback is attached to.
     *
     * - A feedback comment is always linked to exactly **one report**.
     * - This defines the "inverse" side of a one-to-many relationship:
     *   IncidentReportUser (1) → FeedbackComment (many).
     *
     * Example usage:
     *   $comment->report;  // returns the IncidentReportUser model this belongs to
     */
    public function report()
    {
        return $this->belongsTo(IncidentReportUser::class);
    }
}
