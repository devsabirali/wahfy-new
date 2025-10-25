<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasRoles,HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'password',
        'first_name',
        'middle_name',
        'last_name',
        'phone',
        'id_number',
        'payment_status',
        'payment_at',
        'group_leader',
        'group_name',
        'family_leader',
        'family_name',
        'roles', // If you are using a pivot table for roles, you may need to handle this differently
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'payment_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $appends = ['name'];

    public function getNameAttribute()
    {
        return $this->getFullName();
    }

    public function getFullName()
    {
        $parts = array_filter([$this->first_name, $this->middle_name, $this->last_name]);
        return implode(' ', $parts);
    }

    public function organizationMembers()
    {
        return $this->hasMany(OrganizationMember::class);
    }
        public function organizations()
    {
        return $this->hasOne(Organization::class, 'leader_id'); // specify foreign key
    }

    public function user(){
        return $this->hasMany(User::class);
    }

    /**
     * Check if user's probation period (6 months) is completed
     */
    public function isProbationCompleted()
    {
        // Admin users are always considered to have completed probation
        if ($this->hasRole('admin')) {
            return true;
        }

        if (!$this->payment_at) {
            return false;
        }

        $probationEndDate = $this->payment_at->addMonths(6);
        return now()->isAfter($probationEndDate);
    }

    /**
     * Get probation start date (payment_at date)
     */
    public function getProbationStartDate()
    {
        return $this->payment_at;
    }

    /**
     * Get probation end date (6 months after payment_at)
     */
    public function getProbationEndDate()
    {
        if (!$this->payment_at) {
            return null;
        }

        return $this->payment_at->addMonths(6);
    }

    /**
     * Get remaining probation days
     */
    public function getRemainingProbationDays()
    {
        if (!$this->payment_at) {
            return null;
        }

        $probationEndDate = $this->getProbationEndDate();
        $now = now();

        if ($now->isAfter($probationEndDate)) {
            return 0; // Probation completed
        }

        return $now->diffInDays($probationEndDate, false);
    }

    /**
     * Get probation status information
     */
    public function getProbationStatus()
    {
        // For admin users, return completed status (no probation period)
        if ($this->hasRole('admin')) {
            return [
                'status' => 'completed',
                'message' => 'Admin user - no probation period',
                'start_date' => null,
                'end_date' => null,
                'remaining_days' => 0
            ];
        }

        if (!$this->payment_at) {
            return [
                'status' => 'not_started',
                'message' => 'Probation not started - payment pending',
                'start_date' => null,
                'end_date' => null,
                'remaining_days' => null
            ];
        }

        $isCompleted = $this->isProbationCompleted();
        $remainingDays = $this->getRemainingProbationDays();

        if ($isCompleted) {
            return [
                'status' => 'completed',
                'message' => 'Probation completed',
                'start_date' => $this->getProbationStartDate(),
                'end_date' => $this->getProbationEndDate(),
                'remaining_days' => 0
            ];
        }

        return [
            'status' => 'in_progress',
            'message' => "Probation in progress - {$remainingDays} days remaining",
            'start_date' => $this->getProbationStartDate(),
            'end_date' => $this->getProbationEndDate(),
            'remaining_days' => ceil($remainingDays)

        ];
    }

    /**
     * Get user's organization through organization members
     */
    public function getOrganization()
    {
        $organizationMember = $this->organizationMembers()->with('organization')->first();
        return $organizationMember ? $organizationMember->organization : null;
    }

    /**
     * Get incidents that belong to user or their organization
     */
    public function getAccessibleIncidents()
    {
        $query = Incident::with(['user', 'status', 'verifiedBy']);

        // If user is admin, show all incidents
        if ($this->hasRole('admin')) {
            return $query;
        }

        // For regular users, show only their incidents or their organization's incidents
        $organization = $this->getOrganization();
        
        if ($organization) {
            // Get all user IDs in the organization
            $organizationUserIds = $organization->members()->pluck('user_id')->toArray();
            $organizationUserIds[] = $this->id; // Include current user
            
            return $query->whereIn('user_id', $organizationUserIds);
        }

        // If no organization, only show user's own incidents
        return $query->where('user_id', $this->id);
    }
}
