<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSalaryAdvance extends Model
{
    // use HasFactory;

    protected $table = 'staff_salaries_advance'; // Set the correct table name

    protected $fillable = [
        'name',
        'employee_id_auto',
        'phone_number',
        'advance_amount',
        'status',
    ];

    
}

