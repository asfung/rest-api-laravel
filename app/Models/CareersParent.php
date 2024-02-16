<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareersParent extends Model
{
    use HasFactory;
    protected $fillable = ['career_code', 'name'];
}
