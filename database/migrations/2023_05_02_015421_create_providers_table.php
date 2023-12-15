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
        Schema::create('providers', function (Blueprint $table) {
            $table->id()->index();
            $table->string('name', '60');
            $table->text('api_url_order');
            $table->text('api_url_status');
            $table->text('api_url_service');
            $table->text('api_url_profile')->nullable(false);
            $table->string('api_key');
            $table->string('api_id')->nullable(true);
            $table->double('markup');
            $table->enum('type', ['LUAR', 'INDO', 'INDO OLD', 'Manual', 'UNDRCTRL']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
