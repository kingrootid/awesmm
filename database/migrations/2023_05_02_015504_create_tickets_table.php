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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id()->index();
            $table->bigInteger('user_id');
            $table->string('subject');
            $table->string('type');
            $table->longText('message');
            $table->longText('order_id')->nullable(true);
            $table->integer('is_reply')->default(0);
            $table->enum('status', ['Open', 'Closed'])->default('Open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
