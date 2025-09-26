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
        Schema::table('products', function (Blueprint $table) {
            $table->timestamps(); // คำสั่งนี้จะสร้างคอลัมน์ created_at และ updated_at ให้เอง
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropTimestamps(); // คำสั่งสำหรับเวลาย้อนกลับ (rollback)
        });
    }
};
