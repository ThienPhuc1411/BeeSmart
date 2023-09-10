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
        Schema::create('hdct_nhaphang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_sp');
            $table->unsignedBigInteger('id_hd');
            $table->integer('soLuong')->default(1);
            $table->bigInteger('thanhtien');
            $table->text('ghiChu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hdct_nhaphang');
    }
};
