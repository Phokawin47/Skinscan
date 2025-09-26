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
            $table->increments('acne_type_id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->text('causes')->nullable();
            $table->text('treatment_options')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acne_types');
    }
};
