<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'incident_id',
        'user_id',
        'amount',
        'admin_fee',
        'transaction_id',
        'status_id',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'admin_fee' => 'decimal:2'
    ];

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get user's organization through organization members
     */
    public function getUserOrganization()
    {
        return $this->user->getOrganization();
    }

    /**
     * Check if contribution is paid
     */
    public function isPaid()
    {
        $paidStatus = Status::where('type', 'payment_status')
            ->where('name', 'completed')
            ->first();
        
        return $this->status_id === $paidStatus?->id;
    }

    /**
     * Check if contribution is pending
     */
    public function isPending()
    {
        $pendingStatus = Status::where('type', 'payment_status')
            ->where('name', 'pending')
            ->first();
        
        return $this->status_id === $pendingStatus?->id;
    }
}
