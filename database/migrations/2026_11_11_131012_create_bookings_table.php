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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique()->index();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->string('guest_name');
            $table->string('guest_email')->index();
            $table->string('guest_phone');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->unsignedInteger('duration_nights');
            $table->decimal('room_price', 12, 2);
            $table->boolean('has_insurance')->default(false);
            $table->decimal('insurance_fee', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2);
            $table->string('status', 30)->default('unpaid')->index();
            $table->timestamp('check_in_at')->nullable();
            $table->timestamp('check_out_at')->nullable();
            $table->timestamps();

            $table->index(['room_id', 'check_in_date', 'check_out_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
