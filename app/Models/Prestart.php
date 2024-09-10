<?php

namespace App\Models;

use App\Models\Activity;
use App\Models\Incident;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prestart extends Model
{
    use HasFactory;

    protected $fillable = ['workdate', 'project_id', 'foreman_id', 'weather', 'weather_impact', 'pdf_path'];

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
    
    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }
    public function project() {
        return $this->belongsTo(Project::class);
    }

    // In your Prestart.php model
    public function foreman()
    {
        return $this->belongsTo(User::class, 'foreman_id', 'id');
    }

    public function prestartSigned() {
        return $this->hasMany(PrestartSigned::class);
    }
}
