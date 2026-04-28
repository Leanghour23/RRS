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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('location');
            $table->string('room_type')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('price_period')->default('month');
            $table->string('availability_label')->nullable();
            $table->string('capacity_label')->nullable();
            $table->string('size_label')->nullable();
            $table->string('theme')->nullable();
            $table->text('description')->nullable();
            $table->decimal('deposit', 10, 2)->default(0);
            $table->string('bathroom')->nullable();
            $table->string('furnishing')->nullable();
            $table->string('available_from_label')->nullable();
            $table->string('utilities_label')->nullable();
            $table->string('visit_label')->nullable();
            $table->string('contract_label')->nullable();
            $table->string('status')->default('available');
            $table->boolean('is_featured')->default(false);
            $table->timestamps();

            $table->index(['location', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
