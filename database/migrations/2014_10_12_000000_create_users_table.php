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
            $table->Increments('id');
            $table->string('name');
            $table->string('Avatar')->nullable();
            $table->string('email')->unique();
            $table->string('Diachi')->nullable();
            $table->string('sdt',13);
            $table->string('quan');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedInteger('vaiTro')->default(1);
            $table->unsignedInteger('loai')->default(1);
            $table->tinyInteger('status')->default(1);
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
