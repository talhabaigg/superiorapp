<?php

namespace App\Models;

use App\Models\Building;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BuildingTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'wages_assigned',
        'completed_at',
    ];
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

}
