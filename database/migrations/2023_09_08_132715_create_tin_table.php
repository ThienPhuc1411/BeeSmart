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
        Schema::create('tin', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('tieuDe');
            $table->text('tomTat');
            $table->text('noiDung');
            $table->tinyInteger('anHien');
            $table->integer('view');
            $table->unsignedInteger('id_dmtin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tin');
    }
};
