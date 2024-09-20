<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public function employeeServices() {
        return $this->hasMany(EmployeeService::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function graphics() {
        return $this->hasMany(Graphic::class);
    }

    public function entries() {
        return $this->hasMany(Entry::class);
    }
}
