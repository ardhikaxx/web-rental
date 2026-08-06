<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->string('invoice_number')->nullable()->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // customer
            $table->string('customer_name');
            $table->string('customer_phone', 30);
            $table->string('customer_email')->nullable();
            $table->text('address')->nullable();
            $table->string('service_type')->default('rental'); // rental | tour | travel | wedding | airport
            $table->foreignId('fleet_id')->nullable()->constrained('fleets')->nullOnDelete();
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->nullOnDelete();
            $table->boolean('with_driver')->default(true);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('pickup_location')->nullable();
            $table->string('dropoff_location')->nullable();
            $table->text('special_notes')->nullable();

            // harga
            $table->unsignedInteger('duration_days')->default(1);
            $table->decimal('base_price', 15, 2)->default(0);
            $table->decimal('driver_fee', 15, 2)->default(0);
            $table->decimal('extra_cost', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('promo_code_discount', 15, 2)->default(0);
            $table->decimal('tax', 15, 2)->default(0);
            $table->decimal('total_price', 15, 2)->default(0);

            $table->decimal('dp_amount', 15, 2)->default(0);
            $table->decimal('dp_percent', 5, 2)->default(0);

            // promo
            $table->unsignedBigInteger('promo_id')->nullable();
            $table->string('voucher_code')->nullable();

            // workflow status
            $table->string('status')->default('menunggu_konfirmasi');
            // menunggu_konfirmasi | menunggu_pembayaran | pembayaran_diterima | dijadwalkan |
            // berjalan | selesai | dibatalkan | refund | arsip

            $table->string('pickup_status')->default('pending'); // pending | on_pickup | done
            $table->string('return_status')->default('pending');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['status']);
            $table->index(['user_id', 'status']);
            $table->index(['fleet_id', 'start_date', 'end_date']);
            $table->index(['driver_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};