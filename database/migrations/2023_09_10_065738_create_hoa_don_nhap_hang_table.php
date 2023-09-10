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
        Schema::create('hoa_don_nhap_hang', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('MaHD');
            $table->bigInteger('tongtien');
            $table->bigInteger('tongGiamGia')->nullable();
            $table->tinyInteger('trangthai')->default(0);
            $table->integer('ship')->default(0);
            $table->integer('phuthu')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoa_don_nhap_hang');
    }
};
