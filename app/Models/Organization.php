<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'leader_id',
        'status_id',
        'created_by',
        'updated_by'
    ];

    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function members()
    {
        return $this->hasMany(OrganizationMember::class);
    }

    public function leaderHistory()
    {
        return $this->hasMany(OrganizationLeaderHistory::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
