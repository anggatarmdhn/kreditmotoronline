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
        Schema::create('motors', function (Blueprint $table) {
            $table->id();
            $table->string('kode_motor')->unique();
            $table->string('nama_motor', 100);
            $table->foreignId('id_jenis')->nullable()->constrained('jenis_motors')->nullOnDelete();
            $table->decimal('harga_cash', 15, 2); // keep existing harga_cash for backward compatibility, or PDM's harga_jual
            $table->decimal('harga_jual', 15, 2)->default(0); // PDM field
            $table->decimal('dp_minimum', 15, 2)->default(0);
            $table->text('deskripsi_motor')->nullable();
            $table->string('warna', 50)->nullable();
            $table->string('kapasitas_mesin', 10)->nullable();
            $table->year('tahun_produksi')->nullable();
            $table->string('foto1', 255)->nullable();
            $table->string('foto2', 255)->nullable();
            $table->string('foto3', 255)->nullable();
            $table->integer('stok')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motors');
    }
};
