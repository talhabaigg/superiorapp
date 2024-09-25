<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimesheetTask extends Model
{
    use HasFactory;

    // Specify the table name if different from the default pluralized name
    protected $table = 'timesheet_tasks';

    // Specify the fillable attributes
    protected $fillable = [
        'timesheet_id',
        'project_id',
        'building_id',
        'code_id',
        'hours',
    ];

    /**
     * Define the relationship with the Timesheet model.
     */
    public function timesheet()
    {
        return $this->belongsTo(Timesheet::class);
    }

    /**
     * Define the relationship with the Project model.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Define the relationship with the BuildingTask model.
     */
    public function buildingTask()
    {
        return $this->belongsTo(BuildingTask::class, 'code_id');
    }

}
