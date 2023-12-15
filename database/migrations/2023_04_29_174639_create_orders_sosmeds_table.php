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
        Schema::create('orders_sosmeds', function (Blueprint $table) {
            $table->id()->index();
            $table->string('order_id')->nullable(true);
            $table->bigInteger('user_id');
            $table->string('service_name');
            $table->string('service_id');
            $table->string('target');
            $table->double('quantity');
            $table->double('price');
            $table->double('profit');
            $table->longText('comments')->nullable();
            $table->text('link')->nullable();
            $table->double('start_count')->default(0);
            $table->double('remains')->default(0);
            $table->string('date');
            $table->string('from');
            $table->bigInteger('provider');
            $table->enum('status', ['Pending', 'Processing', 'Success', 'Canceled', 'Error', 'Partial'])->default('Pending');
            $table->longText('logs_order');
            $table->longText('logs_status')->nullable();
            $table->integer('refund')->default(0);
            $table->integer('is_canceled')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_sosmeds');
    }
};
