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
        DB::unprepared('
            CREATE TRIGGER generate_invoice_number BEFORE INSERT ON staff_salaries
            FOR EACH ROW
            BEGIN
                DECLARE last_invoice_number INT;
                SET last_invoice_number = (
                    SELECT MAX(SUBSTRING(invoice_number, 4)) FROM staff_salaries
                );

                IF last_invoice_number IS NULL THEN
                    SET NEW.invoice_number = "INV00001";
                ELSE
                    SET last_invoice_number = last_invoice_number + 1;
                    SET NEW.invoice_number = CONCAT("INV", LPAD(last_invoice_number, 5, "0"));
                END IF;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS generate_invoice_number');
    }
};
