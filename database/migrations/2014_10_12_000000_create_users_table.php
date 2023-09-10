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
            $table->bigIncrements('id');
            $table->string('HoTen');
            $table->string('Avatar');
            $table->string('email')->unique();
            $table->string('Diachi')->nullable();
            $table->string('sdt');
            $table->string('quan');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedInteger('id_role');
            $table->unsignedInteger('id_type');
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
