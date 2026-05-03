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
        Schema::create('kredits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengajuan_kredit')->constrained('pengajuan_kredits')->cascadeOnDelete();
            $table->foreignId('id_metode_bayar')->nullable()->constrained('metode_bayars')->nullOnDelete();
            $table->date('tgl_mulai_kredit');
            $table->date('tgl_selesai_kredit')->nullable();
            $table->decimal('sisa_kredit', 15, 2)->default(0);
            $table->enum('status_kredit', ['Dicicil', 'Macet', 'Lunas'])->default('Dicicil');
            $table->string('keterangan_status_kredit', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kredits');
    }
};
