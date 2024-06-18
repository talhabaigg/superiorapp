<?php

namespace App\Models;

use App\Models\BuildingTask;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Building extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'is_active',
    ];


    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function tasks()
    {
        return $this->hasMany(BuildingTask::class);
    }
}