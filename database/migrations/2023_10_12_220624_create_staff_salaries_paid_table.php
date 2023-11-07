<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateStaffSalariesPaidTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('staff_salaries_paid', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('employee_id_auto')->nullable(); // Added employee_id_auto
            $table->string('receipt_number')->default(00000); // RECEIPT NUMBER
            $table->string('employee_mpesa_number')->nullable(); // Added phone_number
            $table->string('senders_mpesa_number')->nullable(); // Added phone_number
            $table->string('amount_paid')->nullable(); // Added phone_number
            $table->string('status')->default('success');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_salaries_paid');
    }
}
