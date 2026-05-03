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
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggan', 255); // from PDM
            $table->string('email', 255)->nullable();
            $table->string('katakunci', 255)->nullable(); // PDM says varchar(15) but 255 is better for bcrypt
            $table->string('no_telp', 15)->nullable();
            $table->string('alamat1', 255)->nullable();
            $table->string('kota1', 255)->nullable();
            $table->string('propinsi1', 255)->nullable();
            $table->string('kodepos1', 255)->nullable();
            $table->string('alamat2', 255)->nullable();
            $table->string('kota2', 255)->nullable();
            $table->string('propinsi2', 255)->nullable();
            $table->string('kodepos2', 255)->nullable();
            $table->string('alamat3', 255)->nullable();
            $table->string('kota3', 255)->nullable();
            $table->string('propinsi3', 255)->nullable();
            $table->string('kodepos3', 255)->nullable();
            $table->string('foto', 255)->nullable();
            // kept for compatibility if needed, but we can make them nullable
            $table->string('nik')->unique()->nullable();
            $table->string('pekerjaan', 120)->nullable();
            $table->decimal('penghasilan_bulanan', 15, 2)->default(0);
            $table->enum('status_pernikahan', ['lajang', 'menikah', 'cerai'])->default('lajang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};
