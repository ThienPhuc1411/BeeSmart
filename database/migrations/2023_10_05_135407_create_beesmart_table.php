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
        Schema::create('loai_cua_hang', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->timestamps();
            $table->string('ten',50);
        });

        Schema::create('cua_hang', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->timestamps();
            $table->string('tenCh',50);
            $table->string('diaChi');
            $table->tinyInteger('member')->default(1);
            $table->integer('idLoaiCh')->unsigned();
            $table->foreign('idLoaiCh')->references('id')->on('loai_cua_hang')->onUpdate('cascade')->onDelete('restrict');
        });

        Schema::create('sub_cua_hang', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->timestamps();
            $table->integer('idCh')->unsigned();
            $table->foreign('idCh')->references('id')->on('cua_hang')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('idUsers')->unsigned();
            $table->foreign('idUsers')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');
        });

        Schema::create('dm_san_pham', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->timestamps();
            $table->string('ten',50);
        });

        Schema::create('thuong_hieu', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->timestamps();
            $table->string('ten',50);
        });

        Schema::create('loai_san_pham', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->timestamps();
            $table->string('ten',50);
        });

        Schema::create('nha_cung_cap', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->timestamps();
            $table->string('ten',50);
            $table->string('diaChi');
            $table->string('sdt',13);
            $table->string('MST',10);
            $table->string('email',70);
            $table->integer('idCh')->unsigned();
            $table->foreign('idCh')->references('id')->on('cua_hang')->onUpdate('cascade')->onDelete('restrict');
        });

        Schema::create('san_pham', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->timestamps();
            $table->string('ten');
            $table->string('maSp',10);
            $table->string('img')->nullable();
            $table->integer('giaVon');
            $table->integer('giaBan');
            $table->double('khuyenMai')->nullable();
            $table->integer('soLuong')->default(1);
            $table->integer('theTich')->nullable();
            $table->integer('khoiLuong')->nullable();
            $table->date('ngayTao');
            $table->tinyInteger('anHien')->default(1);
            $table->tinyInteger('donVi');
            $table->integer('idCh')->unsigned();
            $table->foreign('idCh')->references('id')->on('cua_hang')->onDelete('cascade')->onDelete('restrict');
            $table->integer('idTh')->unsigned();
            $table->foreign('idTh')->references('id')->on('thuong_hieu')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('idDm')->unsigned();
            $table->foreign('idDm')->references('id')->on('dm_san_pham')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('idNcc')->unsigned();
            $table->foreign('idNcc')->references('id')->on('nha_cung_cap')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('idLoai')->unsigned();
            $table->foreign('idLoai')->references('id')->on('loai_san_pham')->onUpdate('cascade')->onDelete('restrict');
        });

        Schema::create('hoa_don_ban_hang', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->timestamps();
            $table->string('maHd');
            $table->integer('tongTien');
            $table->double('tongGiamGia')->default(0);
            $table->integer('idCh')->unsigned();
            $table->foreign('idCh')->references('id')->on('cua_hang')->onUpdate('cascade')->onDelete('restrict');
        });

        Schema::create('hoa_don_chi_tiet_bh', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->timestamps();
            $table->integer('idHd')->unsigned();
            $table->foreign('idHd')->references('id')->on('hoa_don_ban_hang')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('idSp')->unsigned();
            $table->foreign('idSp')->references('id')->on('san_pham')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('soLuong')->default(1);
            $table->integer('tong');
        });

        Schema::create('danh_muc_tin', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->timestamps();
            $table->string('ten');
            $table->tinyInteger('anHien')->default(0);
        });

        Schema::create('tin_tuc', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->timestamps();
            $table->string('tieuDe');
            $table->text('tomTat');
            $table->text('noiDung');
            $table->integer('view')->default(0);
            $table->tinyInteger('anHien')->default(0);
            $table->integer('idDmTin')->unsigned();
            $table->foreign('idDmTin')->references('id')->on('danh_muc_tin')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('idUsers')->unsigned();
            $table->foreign('idUsers')->reference('id')->on('users')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loai_cua_hang');
    }
};
