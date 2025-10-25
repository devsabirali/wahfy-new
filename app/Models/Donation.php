<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'incident_id',
        'first_name',
        'last_name',
        'email',
        'amount',
        'payment_method',
        'payment_status',
        'payment_intent_id',
        'donation_type'
    ];

    protected $casts = [
        'incident_id' => 'integer',
        'amount' => 'decimal:2'
    ];

    public function incident()
    {
        return $this->belongsTo(Incident::class)->withDefault();
    }
} 