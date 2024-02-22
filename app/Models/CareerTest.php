<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerTest extends Model
{
    use HasFactory;
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = ['career_code', 'name', 'tree_lvl', 'id_tree', 'parent_id'];
    // public function children()
    // {
    //     return $this->hasMany(CareerTest::class, 'parent_id');
    // }
    // public function children()
    // {
    //     return $this->hasMany(CareerTest::class, 'parent_id');
    // }
}
