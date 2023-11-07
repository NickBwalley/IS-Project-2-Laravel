<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;


class StaffSalaryPaid extends Model
{
    protected $table = 'staff_salaries_paid'; // Set the correct table name

    protected $fillable = [
        'name',
        'employee_id_auto',
        'employee_mpesa_number',
        'senders_mpesa_number',
        'amount_paid',
    ];

    protected function serializeDate(DateTimeInterface $date): string
{
    return $date->format('d/m/y H:i:s');
}
}
