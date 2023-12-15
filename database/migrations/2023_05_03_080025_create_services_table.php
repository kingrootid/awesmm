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
        Schema::create('services', function (Blueprint $table) {
            $table->id()->index();
            $table->bigInteger('category_id')->default(0);
            $table->string('name');
            $table->text('description');
            $table->double('price');
            $table->double('profit')->default(0);
            $table->double('min');
            $table->double('max');
            $table->enum('type', ['Default', 'Custom Comments', 'Custom Likes']);
            $table->bigInteger('provider');
            $table->bigInteger('service_id');
            $table->integer('status')->default(1);
            $table->integer('is_canceled')->default(0);
            $table->integer('is_refill')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
