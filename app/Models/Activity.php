<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = ['prestart_id', 'name'];

    public function prestart()
    {
        return $this->belongsTo(Prestart::class);
    }
}
