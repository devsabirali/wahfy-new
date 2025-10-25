<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'incident_id',
        'image_path',
        'description',
        'created_by',
        'updated_by'
    ];

    public function incident()
    {
        return $this->belongsTo(Incident::class);
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
