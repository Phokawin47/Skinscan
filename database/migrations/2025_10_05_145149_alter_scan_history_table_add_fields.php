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
        Schema::table('scan_history', function (Blueprint $table) {
            // มีอยู่แล้ว: scan_id (PK), user_id, scan_image_path, scan_timestamp
            if (!Schema::hasColumn('scan_history','skin_type')) {
                $table->string('skin_type',50)->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('scan_history','result_image_path')) {
                $table->string('result_image_path')->nullable()->after('skin_type');
            }
            // ปรับ timestamps ให้เป็นแบบ Laravel
            if (!Schema::hasColumn('scan_history','created_at')) {
                $table->timestamps(); // เพิ่ม created_at/updated_at
            }
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
