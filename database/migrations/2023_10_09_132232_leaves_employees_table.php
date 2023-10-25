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
        Schema::create('leaves_employees', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('leave_type')->nullable();
            $table->string('from_date')->nullable();
            $table->string('to_date')->nullable();
            $table->string('day')->nullable();
            $table->string('leave_reason')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves_employees');
    }
};
