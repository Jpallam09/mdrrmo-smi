<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\IncidentReporting\StaffLocation;
use App\Models\IncidentReporting\IncidentReportUser;

/**
 * /**
 * /**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $user_name
 * @property string $email
 * @property string|null $profile_picture
 * @property string $first_name
 * @property string $last_name
 * @property string $user_name
 * @property string|null $phone
 * @property \Illuminate\Notifications\DatabaseNotificationCollection $notifications
 * @property \Illuminate\Notifications\DatabaseNotificationCollection $unreadNotifications
 * @method \Illuminate\Notifications\DatabaseNotificationCollection notifications()
 * @method \Illuminate\Notifications\DatabaseNotificationCollection unreadNotifications()
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'first_name',
        'last_name',
        'user_name',
        'email',
        'phone',
        'role',
        'password',
        'profile_picture',
    ];
    /* ------------------------------- RELATIONSHIPS ------------------------ */

    /**
     * One account ⇢ many app‑specific roles.
     */
    public function incidentReports()
    {
        return $this->hasMany(IncidentReportUser::class);
    }

    public function isReportingStaff(): bool
    {
        return $this->hasRole('incident_reporting', 'staff');
    }

    public function isReportingAdmin(): bool
    {
        return $this->hasRole('incident_reporting', 'admin');
    }
    public function isDocumentStaff(): bool
    {
        return $this->hasRole('document_request', 'staff');
    }

    public function isDocumentAdmin(): bool
    {
        return $this->hasRole('document_request', 'admin');
    }

    public function roles()
    {
        return $this->hasMany(UserRole::class);
    }
    /* --------------------------------- HELPERS ---------------------------- */

    /**
     * Quickly check: does this user have *exactly* `$role` in `$app`?
     *
     * @param  string  $app   'incident_reporting' | 'document_request'
     * @param  string  $role  'user' | 'staff' | 'admin'
     */
    public function hasRole(string $app, string $role): bool
    {
        return $this->roles()
            ->where('app', $app)
            ->where('role', $role)
            ->exists();
    }

    // A staff user can have many location records
    public function staffLocation()
    {
        return $this->hasOne(StaffLocation::class);
    }

}
