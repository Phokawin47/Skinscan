<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('acne_types', function (Blueprint $table) {
        $table->increments('acne_type_id'); // INT UNSIGNED (PK)
        $table->string('acne_type_name')->unique();
        $table->timestamps();

        // บังคับ engine ในกรณีจำเป็น
        $table->engine = 'InnoDB';
    });}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acne_types');
    }
};
