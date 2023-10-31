<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('staff_salaries_advance', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('employee_id_auto')->nullable(); // Added employee_id_auto
            $table->string('on_date')->nullable(00000); 
            $table->string('advance_amount')->nullable(00000); 
            $table->string('status')->default('unpaid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_salaries_advance');
    }
};
