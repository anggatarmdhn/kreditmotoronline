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
            $table->boolean('dp_paid')->default(false)->after('catatan');
            $table->string('midtrans_order_id')->nullable()->after('dp_paid');
            $table->timestamp('dp_paid_at')->nullable()->after('midtrans_order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_kredits', function (Blueprint $table) {
            $table->dropColumn(['dp_paid', 'midtrans_order_id', 'dp_paid_at']);
        });
    }
};
