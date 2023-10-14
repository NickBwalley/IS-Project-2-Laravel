<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSalaryPaid extends Model
{
    protected $table = 'staff_salaries_paid'; // Set the correct table name

    protected $fillable = [
        'name',
        'employee_id_auto',
        'employee_mpesa_number',
        'senders_mpesa_number',
        'number_of_kgs_harvested',
        'shillings_per_kg',
        'amount_paid',
    ];
}
