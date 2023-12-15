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
        Schema::create('methods', function (Blueprint $table) {
            $table->id()->index();
            $table->string('name', 60);
            $table->longText('note');
            $table->double('min');
            $table->double('bonus');
            $table->string('rate', 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('methods');
    }
};
