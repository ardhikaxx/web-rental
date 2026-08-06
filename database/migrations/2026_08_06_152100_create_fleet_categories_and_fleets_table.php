<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fleet_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('fleets', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('category_id')->nullable()->constrained('fleet_categories')->nullOnDelete();
            $table->string('brand');
            $table->string('model');
            $table->string('type')->nullable();
            $table->string('year');
            $table->string('license_plate')->unique();
            $table->string('frame_number')->nullable();
            $table->string('engine_number')->nullable();
            $table->string('color')->nullable();
            $table->unsignedInteger('capacity')->default(4);
            $table->string('transmission')->nullable();
            $table->string('fuel')->nullable();
            $table->decimal('daily_price', 15, 2);
            $table->decimal('weekly_price', 15, 2)->nullable();
            $table->decimal('monthly_price', 15, 2)->nullable();
            $table->decimal('price_with_driver', 15, 2)->nullable();
            $table->decimal('price_without_driver', 15, 2)->nullable();
            $table->string('location')->nullable();
            $table->text('facilities')->nullable();
            $table->string('stnk_expired_at')->nullable();
            $table->string('status')->default('tersedia'); // tersedia | dipesan | berjalan | maintenance | nonaktif
            $table->string('primary_image')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->index(['category_id', 'status']);
            $table->index('brand');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fleets');
        Schema::dropIfExists('fleet_categories');
    }
};