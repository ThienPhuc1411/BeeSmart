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
        Schema::create('nha_cung_cap', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('ten');
            $table->string('diachi');
            $table->string('email')->unique();
            $table->string('sdt');
            $table->string('MST');            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nha_cung_cap');
    }
};
