<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // scan_history: ใช้ BIGINT + columns ที่ต้องใช้จริง
        Schema::create('scan_history', function (Blueprint $table) {
            $table->increments('scan_id');           // INT UNSIGNED
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('skin_type')->default('unknown');
            $table->string('result_image_path')->nullable();
            $table->timestamp('scan_timestamp')->useCurrent();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->index(['user_id', 'scan_timestamp']);

            $table->engine = 'InnoDB';
        });


        // scan_results: FK → BIGINT เสมอ
        Schema::create('scan_results', function (Blueprint $table) {
            $table->bigIncrements('id');             // คีย์หลักของแถว (BIGINT ก็ได้ ไม่เกี่ยวกับ FK ด้านล่าง)
            $table->unsignedInteger('scan_id');      // ต้องตรงกับ scan_history.scan_id (INT UNSIGNED)
            $table->unsignedInteger('acne_type_id'); // ต้องตรงกับ acne_types.acne_type_id (INT UNSIGNED)
            $table->string('class_name', 100)->nullable();
            $table->timestamps();

            $table->foreign('scan_id')
                ->references('scan_id')->on('scan_history')
                ->cascadeOnDelete();

            $table->foreign('acne_type_id')
                ->references('acne_type_id')->on('acne_types')
                ->cascadeOnDelete();

            $table->unique(['scan_id','acne_type_id'], 'scan_results_scan_acne_unique');

            $table->index(['scan_id', 'acne_type_id']);

            $table->engine = 'InnoDB';
        });

    }

    public function down(): void
    {
        Schema::table('scan_results', function (Blueprint $table) {
            $table->dropForeign(['scan_id']);
            $table->dropForeign(['acne_type_id']);
        });
        Schema::dropIfExists('scan_results');

        Schema::table('scan_history', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('scan_history');
    }
};
