<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Costcode extends Model
{
    use HasFactory, SoftDeletes; // Include the SoftDeletes trait

    protected $fillable = [
        'code', 
        'description', 
        'unit', 
        'category_1', 
        'category_2', 
        'category_3', 
        'category_4', 
        'created_by', // Add these fields if you plan to mass-assign them
        'updated_by'
    ];

    // Relationship to the user who created the record
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relationship to the user who last updated the record
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
