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
        Schema::create('angsurans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kredit')->constrained('kredits')->cascadeOnDelete();
            $table->unsignedSmallInteger('angsuran_ke');
            $table->date('jatuh_tempo');
            $table->decimal('jumlah_tagihan', 15, 2);
            $table->decimal('jumlah_bayar', 15, 2)->default(0);
            $table->date('tanggal_bayar')->nullable();
            $table->foreignId('metode_bayar_id')->nullable()->constrained('metode_bayars')->nullOnDelete();
            $table->enum('status', ['belum_bayar', 'lunas', 'tunggak'])->default('belum_bayar');
            $table->string('bukti_bayar')->nullable();
            $table->text('keterangan')->nullable(); // From PDM
            $table->timestamps();

            $table->unique(['id_kredit', 'angsuran_ke']);
            $table->index(['status', 'jatuh_tempo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('angsurans');
    }
};
