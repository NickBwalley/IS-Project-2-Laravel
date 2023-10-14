<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateStaffSalariesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('staff_salaries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('employee_id_auto')->nullable(); // Added employee_id_auto
            $table->string('invoice_number')->default('00000'); // INVOICE NUMBER
            $table->string('phone_number')->nullable(); // Added phone_number
            $table->string('number_of_kgs_harvested')->nullable(); // Changed 'salary' to 'number_of_kgs_harvested'
            $table->decimal('shillings_per_kg', 8, 2)->default(8.00); // Added 'shillings_per_kg' field
            $table->decimal('estimated_payout', 10, 2)->nullable(); // Added 'estimated_payout' field
            $table->string('status')->default('pending');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('staff_salaries');
    }
}

