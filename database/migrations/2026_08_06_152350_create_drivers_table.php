<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('photo')->nullable();
            $table->text('address')->nullable();
            $table->string('license_number')->nullable();
            $table->date('license_expired_at')->nullable();
            $table->string('license_type', 20)->default('SIM B1');
            $table->string('status')->default('aktif'); // aktif | cuti | tugas
            $table->decimal('rating', 3, 2)->default(5.00);
            $table->unsignedBigInteger('experience_trips')->default(0);
            $table->string('experience')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};