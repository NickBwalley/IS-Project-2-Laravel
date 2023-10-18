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
        Schema::create('departments_assigned', function (Blueprint $table) {
            $table->id();
            $table->string('department')->nullable();
            $table->string('employee_name')->nullable();
            $table->string('employee_id_auto')->default(00000);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments_assigned');
    }
};
