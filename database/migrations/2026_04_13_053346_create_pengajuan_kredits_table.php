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
        Schema::create('pengajuan_kredits', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pengajuan')->unique();
            $table->foreignId('pelanggan_id')->constrained('pelanggans')->cascadeOnDelete();
            $table->foreignId('motor_id')->constrained('motors')->restrictOnDelete();
            $table->foreignId('jenis_cicilan_id')->constrained('jenis_cicilans')->restrictOnDelete();
            $table->foreignId('marketing_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('harga_cash', 15, 2);
            $table->decimal('dp', 15, 2);
            $table->decimal('pokok_hutang', 15, 2);
            $table->decimal('bunga_persen', 5, 2);
            $table->decimal('total_pembiayaan', 15, 2);
            $table->decimal('angsuran_per_bulan', 15, 2);
            $table->unsignedSmallInteger('tenor_bulan');
            $table->date('tanggal_pengajuan');
            $table->string('url_kk', 255)->nullable();
            $table->string('url_ktp', 255)->nullable();
            $table->string('url_npwp', 255)->nullable();
            $table->string('url_slip_gaji', 255)->nullable();
            $table->string('url_foto', 255)->nullable();
            $table->enum('status', ['Menunggu Konfirmasi', 'Diproses', 'Dibatalkan Pembeli', 'Dibatalkan Penjual', 'Bermasalah', 'Diterima', 'Aktif'])->default('Menunggu Konfirmasi');
            $table->text('catatan')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'tanggal_pengajuan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_kredits');
    }
};
