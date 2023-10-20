<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentsAssigned extends Model
{
    protected $table = 'departments_assigned'; // Set the correct table name
 
    protected $fillable = [
        'department',
        'employee_name',
    ];
}
