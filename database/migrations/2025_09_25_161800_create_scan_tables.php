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
        Schema::create('scan_history', function (Blueprint $table) {
            $table->increments('scan_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('scan_image_path')->nullable();
            $table->timestamp('scan_timestamp')->useCurrent();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('scan_results', function (Blueprint $table) {
            $table->integer('scan_id')->unsigned();
            $table->integer('acne_type_id')->unsigned();

            $table->foreign('scan_id')->references('scan_id')->on('scan_history');
            $table->foreign('acne_type_id')->references('acne_type_id')->on('acne_types');
            $table->primary(['scan_id', 'acne_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scan_tables');
    }
};
