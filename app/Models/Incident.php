<?php

namespace App\Models;

use App\Models\Prestart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Incident extends Model
{
    use HasFactory;
    protected $fillable = ['prestart_id', 'name'];

    public function prestart()
    {
        return $this->belongsTo(Prestart::class);
    }
}
