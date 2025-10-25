<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentReminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'organization_id',
        'charge_id',
        'reminder_date',
        'due_date',
        'amount',
        'status',
        'notes',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'reminder_date' => 'date',
        'due_date' => 'date',
        'amount' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function charge()
    {
        return $this->belongsTo(Charge::class);
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
