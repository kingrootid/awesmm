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
        Schema::create('order_requests', function (Blueprint $table) {
            $table->id()->index();
            $table->bigInteger('order_id')->index();
            $table->bigInteger('provider_order_id')->index();
            $table->bigInteger('provider_request_id')->index();
            $table->bigInteger('user_id')->index();
            $table->enum('type', ['Cancel', 'Refill'])->default('Cancel');
            $table->enum('status', ['Pending', 'Process', 'Success', 'Canceled'])->default('Pending');
            $table->bigInteger('provider_id');
            $table->longText('log_process')->nullable();
            $table->longText('log_respond')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_requests');
    }
};
