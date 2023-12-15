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
        Schema::create('activity_services', function (Blueprint $table) {
            $table->id()->index();
            $table->bigInteger('services_id');
            $table->bigInteger('services_provider_id');
            $table->string('services_provider_name');
            $table->string('name');
            $table->enum('type', ['increase', 'decrease', 'enable', 'disable']);
            $table->double('amount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_services');
    }
};
