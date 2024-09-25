<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employeetype extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 
        'costcode_id', 
        'full_time', 
        'created_by', 
        
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function costcode()
    {
        return $this->hasOne(Costcode::class, 'id','costcode_id');
    }
}
