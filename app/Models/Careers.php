<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Careers extends Model
{
    use HasFactory;
    // protected $fillable = ['career_code', 'name', 'tree_lvl', 'id_tree'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = ['career_code', 'name', 'tree_lvl', 'id_tree', 'parent_id'];
}
