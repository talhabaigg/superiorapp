<?php

namespace App\Models;

use App\Models\Swms;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name',
        'abbreviated_project_name',
        'subsidiary',
        'project_number',
        'description',
        'notes',
        'timezone',
        'average_hourly_rate',
        'estimated_hours',
        'deadline',
        'completed',
        'daily_qr_code',
    ];

   
}