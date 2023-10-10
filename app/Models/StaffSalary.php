<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSalary extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'employee_id_auto',
        'phone_number',
        'number_of_kgs_harvested',
        'shillings_per_kg',
        'estimated_payout',
    ];
}
