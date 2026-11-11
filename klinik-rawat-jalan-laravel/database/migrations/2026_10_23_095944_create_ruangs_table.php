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
        Schema::create('ruangs', function (Blueprint $table) {
    $table->id();
    $table->string('nama_ruang', 50);
    $table->enum('jenis_poli', ['Gigi', 'Umum']);
    $table->string('gedung', 20);
    $table->tinyInteger('lantai');
    $table->string('kapasitas', 50);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruangs');
    }
};
