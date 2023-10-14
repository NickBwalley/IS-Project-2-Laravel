<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER generate_receipt_number BEFORE INSERT ON staff_salaries_paid
            FOR EACH ROW
            BEGIN
                DECLARE last_receipt_number INT;
                DECLARE new_receipt_number INT;
                
                -- Get the last receipt number
                SET last_receipt_number = (
                    SELECT MAX(SUBSTRING(receipt_number, 7)) FROM staff_salaries_paid
                );
                
                -- Check if there are no existing records
                IF last_receipt_number IS NULL THEN
                    SET NEW.receipt_number = "RCDKNJ0001";
                ELSE
                    -- Increment the last receipt number
                    SET new_receipt_number = last_receipt_number + 1;
                    
                    -- Pad the new receipt number with leading zeros (5 digits)
                    SET NEW.receipt_number = CONCAT("RCDKNJ", LPAD(new_receipt_number, 4, "0"));
                END IF;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // You can remove the trigger during the rollback if needed
        DB::unprepared('DROP TRIGGER IF EXISTS generate_receipt_number');
    }
};
