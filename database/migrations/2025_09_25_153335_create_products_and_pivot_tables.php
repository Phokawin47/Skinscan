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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('product_id');
            $table->string('product_name')->nullable();

            // --- ส่วนที่เพิ่มเข้ามา ---
            $table->integer('brand_id')->unsigned()->nullable();
            // -----------------------

            $table->string('image_path')->nullable();
            $table->text('usage_details')->nullable();
            $table->string('suitability_info')->nullable();
            $table->integer('category_id')->unsigned()->nullable();
            $table->unsignedBigInteger('added_by_user_id')->nullable();
            $table->timestamps();

            // --- เพิ่ม Foreign Key สำหรับ brand_id ---
            $table->foreign('brand_id')->references('brand_id')->on('brands')->onDelete('set null');
            // ------------------------------------

            $table->foreign('category_id')->references('category_id')->on('product_categories');
            $table->foreign('added_by_user_id')->references('id')->on('users');
        });

        // ... ส่วนของ product_ingredients และ product_skin_types เหมือนเดิม ...
        Schema::create('product_ingredients', function (Blueprint $table) {
            $table->integer('product_id')->unsigned();
            $table->integer('ingredient_id')->unsigned();
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
            $table->foreign('ingredient_id')->references('ingredient_id')->on('ingredients')->onDelete('cascade');
            $table->primary(['product_id', 'ingredient_id']);
        });

        Schema::create('product_skin_types', function (Blueprint $table) {
            $table->integer('product_id')->unsigned();
            $table->integer('skin_type_id')->unsigned();
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
            $table->foreign('skin_type_id')->references('skin_type_id')->on('skin_types')->onDelete('cascade');
            $table->primary(['product_id', 'skin_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_ingredients');
        Schema::dropIfExists('product_skin_types');
    }
};
