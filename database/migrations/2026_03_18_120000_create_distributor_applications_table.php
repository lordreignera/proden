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
        Schema::create('distributor_applications', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('phone', 30);
            $table->string('email')->nullable();
            $table->string('business_name')->nullable();
            $table->string('district', 120);
            $table->text('address')->nullable();
            $table->text('experience')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('new'); // new, contacted, approved, rejected
            $table->timestamp('contacted_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributor_applications');
    }
};
