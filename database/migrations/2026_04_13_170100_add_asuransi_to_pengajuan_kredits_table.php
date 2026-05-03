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
        Schema::table('pengajuan_kredits', function (Blueprint $table) {
            $table->foreignId('asuransi_id')->nullable()->after('jenis_cicilan_id')->constrained('asuransis')->nullOnDelete();
            $table->decimal('biaya_asuransi_per_bulan', 15, 2)->default(0)->after('bunga_persen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_kredits', function (Blueprint $table) {
            $table->dropConstrainedForeignId('asuransi_id');
            $table->dropColumn('biaya_asuransi_per_bulan');
        });
    }
};
