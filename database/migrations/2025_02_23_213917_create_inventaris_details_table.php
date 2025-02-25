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
        Schema::create('inventaris_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventaris_id')->constrained('inventaris')->onDelete('cascade');
            $table->string('kode_barang')->default('-');
            $table->string('nama_barang');
            $table->string('merk_type')->default('-');
            $table->year('tahun_pembelian');
            $table->integer('jumlah');
            $table->enum('kondisi', ['Baik', 'Buruk'])->default('Baik');
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris_details');
    }
};
