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
        Schema::create('alat_medis', function (Blueprint $table) {
    $table->id();
    $table->foreignId('ruang_id')->constrained('ruangs')->onDelete('cascade');
    $table->string('nama_alat', 100);
    $table->integer('jumlah');
    $table->enum('kondisi', ['Baik', 'Perlu Perawatan', 'Rusak']);
    $table->smallInteger('tahun_pengadaan');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alat_medis');
    }
};
