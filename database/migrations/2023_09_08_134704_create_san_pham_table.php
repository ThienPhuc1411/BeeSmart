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
        Schema::create('san_pham', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('ten');
            $table->string('img')->nullable();
            $table->bigInteger('giaVon');
            $table->bigInteger('giaBan');
            $table->bigInteger('giaKM')->nullable();
            $table->integer('donVi')->default(0);
            $table->integer('soLuong')->default(0);
            $table->integer('khoiLuong')->default(0);
            $table->integer('theTich')->default(0);
            $table->tinyInteger('anHien');
            $table->unsignedBigInteger('id_ch');
            $table->unsignedBigInteger('id_ncc');
            $table->unsignedInteger('id_dmsp');
            $table->unsignedInteger('id_th');
            $table->unsignedInteger('id_loaisp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('san_pham');
    }
};
