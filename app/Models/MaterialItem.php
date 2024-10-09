<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['code', 'description', 'supplier_name', 'costcode'];
}
