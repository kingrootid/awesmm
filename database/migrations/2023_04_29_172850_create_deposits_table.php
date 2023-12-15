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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id()->index();
            $table->bigInteger('user_id');
            $table->string('method');
            $table->string('method_ref')->nullable(true);
            $table->double('amount');
            $table->double('get');
            $table->longText('note');
            $table->enum('status', ['Pending', 'Canceled', 'Success']);
            $table->longText('log_payment')->nullable(true);
            $table->longText('qr_url')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
