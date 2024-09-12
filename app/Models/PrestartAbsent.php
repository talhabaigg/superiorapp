<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestartAbsent extends Model
{
    use HasFactory;

    protected $fillable = ['prestart_id', 'user_id', 'status', 'reason', 'notes'];

    // Explicitly define the table name
    protected $table = 'prestart_absents';

    // Define relationship to Prestart
    public function prestart()
    {
        return $this->belongsTo(Prestart::class);
    }

    // Define relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
