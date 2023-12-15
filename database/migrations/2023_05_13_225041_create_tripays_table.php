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
        Schema::create('tripays', function (Blueprint $table) {
            $table->id()->index();
            $table->string('group');
            $table->string('code');
            $table->string('name');
            $table->string('type');
            $table->text('images');
            $table->string('fee_flat');
            $table->string('fee_percent');
            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tripays');
    }
};
