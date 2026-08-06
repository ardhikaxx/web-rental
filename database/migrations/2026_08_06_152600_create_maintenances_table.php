<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('fleet_id')->constrained('fleets')->cascadeOnDelete();
            $table->string('type'); // servis | ganti_oli | perbaikan | pajak | asuransi | lainnya
            $table->date('date');
            $table->decimal('cost', 15, 2)->default(0);
            $table->text('description')->nullable();
            $table->string('workshop')->nullable();
            $table->integer('mileage')->nullable();
            $table->date('next_maintenance_at')->nullable();
            $table->date('valid_until')->nullable(); // masa berlaku pajak/asuransi
            $table->string('status')->default('selesai'); // rencana | in_service | selesai
            $table->string('evidence_image')->nullable();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->index(['fleet_id', 'date']);
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};