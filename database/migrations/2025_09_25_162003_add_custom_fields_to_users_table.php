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
        Schema::table('users', function (Blueprint $table) {
            // เปลี่ยนชื่อคอลัมน์ 'name' เป็น 'username'
            $table->renameColumn('name', 'username');

            // เพิ่มคอลัมน์ใหม่
            $table->string('gender')->nullable()->after('username');
            $table->integer('age')->nullable()->after('gender');
            $table->string('first_name')->nullable()->after('age');
            $table->string('last_name')->nullable()->after('first_name');
            $table->boolean('is_sensitive_skin')->nullable()->after('password');
            $table->text('allergies')->nullable()->after('is_sensitive_skin');

            // เพิ่มคอลัมน์สำหรับ Foreign Key
            $table->integer('role_id')->unsigned()->nullable()->after('allergies');
            $table->integer('skin_type_id')->unsigned()->nullable()->after('role_id');

            // สร้าง Foreign Key Constraints
            $table->foreign('role_id')->references('role_id')->on('roles');
            $table->foreign('skin_type_id')->references('skin_type_id')->on('skin_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
