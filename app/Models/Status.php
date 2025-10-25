<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'created_by',
        'updated_by'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }

    public function organizationMembers()
    {
        return $this->hasMany(OrganizationMember::class);
    }
}
