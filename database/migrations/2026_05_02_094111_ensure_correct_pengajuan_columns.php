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
            if (Schema::hasColumn('pengajuan_kredits', 'url_npwp')) {
                $table->dropColumn('url_npwp');
            }
            if (!Schema::hasColumn('pengajuan_kredits', 'url_slip_gaji')) {
                $table->string('url_slip_gaji', 255)->after('url_kk')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_kredits', function (Blueprint $table) {
            if (!Schema::hasColumn('pengajuan_kredits', 'url_npwp')) {
                $table->string('url_npwp', 255)->after('url_kk')->nullable();
            }
        });
    }
};
