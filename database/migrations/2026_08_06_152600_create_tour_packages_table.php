<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('destination')->nullable();
            $table->unsignedInteger('duration_days')->default(1);
            $table->unsignedInteger('duration_nights')->default(0);
            $table->decimal('price_per_person', 15, 2)->default(0);
            $table->decimal('price_per_group', 15, 2)->nullable();
            $table->unsignedInteger('min_group')->default(0);
            $table->unsignedInteger('max_group')->default(0);
            $table->text('description')->nullable();
            $table->text('itinerary')->nullable();
            $table->text('facilities')->nullable();
            $table->text('terms')->nullable();
            $table->string('thumbnail')->nullable();
            $table->text('gallery')->nullable();
            $table->string('status')->default('aktif');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->index('status');
        });

        Schema::create('tour_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_package_id')->constrained('tour_packages')->cascadeOnDelete();
            $table->date('departure_date');
            $table->unsignedInteger('quota')->default(0);
            $table->unsignedInteger('booked')->default(0);
            $table->string('status')->default('buka');
            $table->timestamps();
        });

        Schema::create('tour_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('tour_package_id')->constrained('tour_packages')->cascadeOnDelete();
            $table->foreignId('tour_schedule_id')->nullable()->constrained('tour_schedules')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('customer_name');
            $table->string('customer_phone', 30);
            $table->string('customer_email')->nullable();
            $table->unsignedInteger('participants')->default(1);
            $table->decimal('total_price', 15, 2)->default(0);
            $table->string('status')->default('menunggu_konfirmasi');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_bookings');
        Schema::dropIfExists('tour_schedules');
        Schema::dropIfExists('tour_packages');
    }
};