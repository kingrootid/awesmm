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
        Schema::create('users', function (Blueprint $table) {
            $table->id()->index();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('balance');
            $table->string('api_key')->nullable();
            $table->string('phone');
            $table->integer('role_id')->default(1);
            $table->integer('permanent_role')->default(0);
            $table->string('read_news')->default('0');
            $table->integer('refferal_active')->default('0');
            $table->string('refferal_code')->nullable();
            $table->bigInteger('refferal_id')->nullable();
            $table->double('refferal_visit')->default('0');
            $table->double('refferal_revenue')->default('0');
            $table->string('email_verify_code')->nullable();
            $table->integer('email_verify_status')->default('0');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
