<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('intercity_travel', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('route_origin');
            $table->string('route_destination');
            $table->string('slug')->unique();
            $table->decimal('price', 15, 2)->default(0);
            $table->integer('travel_time_hours')->default(1);
            $table->string('departure_time')->nullable();
            $table->unsignedInteger('quota')->default(4);
            $table->text('pickup_points')->nullable();
            $table->text('dropoff_points')->nullable();
            $table->string('status')->default('aktif');
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->index(['route_origin', 'route_destination']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('intercity_travel');
    }
};