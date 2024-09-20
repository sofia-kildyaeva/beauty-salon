<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    public function type() {
        return $this->belongsTo(Type::class);
    }

    public function employeeServices() {
        return $this->hasMany(EmployeeService::class);
    }

    public function entries() {
        return $this->hasMany(Entry::class);
    }
}
