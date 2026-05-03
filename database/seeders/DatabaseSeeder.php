<?php

namespace Database\Seeders;

use App\Models\Angsuran;
use App\Models\Asuransi;
use App\Models\JenisCicilan;
use App\Models\MetodeBayar;
use App\Models\Motor;
use App\Models\Pelanggan;
use App\Models\PengajuanKredit;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            MasterDataSeeder::class,
        ]);

        $adminRoleId = Role::query()->where('slug', 'admin')->value('id');
        $marketingRoleId = Role::query()->where('slug', 'marketing')->value('id');
        $surveyorRoleId = Role::query()->where('slug', 'surveyor')->value('id');
        $kolektorRoleId = Role::query()->where('slug', 'kolektor')->value('id');
        $klienRoleId = Role::query()->where('slug', 'klien')->value('id');
        $managerRoleId = Role::query()->where('slug', 'manager')->value('id');
        $ownerRoleId = Role::query()->where('slug', 'owner')->value('id');

        User::query()->whereIn('email', [
            'admin@kreditmotor.test',
            'marketing@kreditmotor.test',
            'surveyor@kreditmotor.test',
            'kolektor@kreditmotor.test',
        ])->delete();

        User::query()->updateOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Admin Kredit', 'password' => 'password', 'role_id' => $adminRoleId, 'email_verified_at' => now()]
        );

        User::query()->updateOrCreate(
            ['email' => 'marketing@gmail.com'],
            ['name' => 'Marketing Kredit', 'password' => 'password', 'role_id' => $marketingRoleId, 'email_verified_at' => now()]
        );

        User::query()->updateOrCreate(
            ['email' => 'surveyor@gmail.com'],
            ['name' => 'Surveyor Kredit', 'password' => 'password', 'role_id' => $surveyorRoleId, 'email_verified_at' => now()]
        );

        User::query()->updateOrCreate(
            ['email' => 'kolektor@gmail.com'],
            ['name' => 'Kolektor Kredit', 'password' => 'password', 'role_id' => $kolektorRoleId, 'email_verified_at' => now()]
        );

        User::query()->updateOrCreate(
            ['email' => 'manager@gmail.com'],
            ['name' => 'Manager Area', 'password' => 'password', 'role_id' => $managerRoleId, 'email_verified_at' => now()]
        );

        User::query()->updateOrCreate(
            ['email' => 'owner@gmail.com'],
            ['name' => 'Owner', 'password' => 'password', 'role_id' => $ownerRoleId, 'email_verified_at' => now()]
        );

        User::query()->updateOrCreate(
            ['email' => 'klien@gmail.com'],
            ['name' => 'Klien Kredit', 'password' => 'password', 'role_id' => $klienRoleId, 'email_verified_at' => now()]
        );

        $this->seedDemoTransaksi();
    }

    private function seedDemoTransaksi(): void
    {
        $marketingId = User::query()->where('email', 'marketing@gmail.com')->value('id');
        $jenisCicilan = JenisCicilan::query()->where('is_active', true)->orderBy('tenor_bulan')->first();
        $asuransi = Asuransi::query()->where('is_active', true)->orderBy('id')->first();
        $metodeTransferId = MetodeBayar::query()->where('kode', 'TRF')->value('id');

        $pelangganRows = Pelanggan::query()->orderBy('id')->take(2)->get();
        $motorRows = Motor::query()->where('is_active', true)->orderBy('harga_cash')->take(2)->get();

        if (! $marketingId || ! $jenisCicilan || $pelangganRows->isEmpty() || $motorRows->isEmpty()) {
            return;
        }

        foreach ($motorRows as $index => $motor) {
            $pelanggan = $pelangganRows[$index % $pelangganRows->count()];

            $hargaCash = (float) $motor->harga_cash;
            $dp = max((float) $motor->dp_minimum, $hargaCash * 0.15);
            $pokokHutang = max($hargaCash - $dp, 0);
            $bunga = (float) $jenisCicilan->bunga_persen;
            $tenor = (int) $jenisCicilan->tenor_bulan;
            $biayaAsuransiPerBulan = $asuransi ? ($pokokHutang * (((float) $asuransi->margin_persen) / 100)) : 0;
            $totalPembiayaan = ($pokokHutang * (1 + (($bunga / 100) * ($tenor / 12)))) + ($biayaAsuransiPerBulan * $tenor);
            $angsuranPerBulan = $tenor > 0 ? ($totalPembiayaan / $tenor) : $totalPembiayaan;

            $pengajuan = PengajuanKredit::query()->updateOrCreate(
                ['kode_pengajuan' => 'PGJ-2026-00'.($index + 1)],
                [
                    'pelanggan_id' => $pelanggan->id,
                    'motor_id' => $motor->id,
                    'jenis_cicilan_id' => $jenisCicilan->id,
                    'asuransi_id' => $asuransi?->id,
                    'marketing_id' => $marketingId,
                    'approved_by' => null,
                    'harga_cash' => $hargaCash,
                    'dp' => $dp,
                    'pokok_hutang' => $pokokHutang,
                    'bunga_persen' => $bunga,
                    'biaya_asuransi_per_bulan' => $biayaAsuransiPerBulan,
                    'total_pembiayaan' => $totalPembiayaan,
                    'angsuran_per_bulan' => $angsuranPerBulan,
                    'tenor_bulan' => $tenor,
                    'tanggal_pengajuan' => now()->subDays(10 + $index),
                    'status' => 'Diterima',
                    'catatan' => 'Data demo pembayaran',
                    'approved_at' => now()->subDays(9 + $index),
                ]
            );

            $kredit = \App\Models\Kredit::query()->updateOrCreate(
                ['id_pengajuan_kredit' => $pengajuan->id],
                [
                    'id_metode_bayar' => $metodeTransferId,
                    'tgl_mulai_kredit' => now()->subDays(9 + $index),
                    'sisa_kredit' => $totalPembiayaan - $angsuranPerBulan,
                    'status_kredit' => 'Dicicil',
                ]
            );

            Angsuran::query()->updateOrCreate(
                ['id_kredit' => $kredit->id, 'angsuran_ke' => 1],
                [
                    'jatuh_tempo' => now()->subDays(20),
                    'jumlah_tagihan' => $angsuranPerBulan,
                    'jumlah_bayar' => $angsuranPerBulan,
                    'tanggal_bayar' => now()->subDays(18),
                    'metode_bayar_id' => $metodeTransferId,
                    'status' => 'lunas',
                ]
            );

            Angsuran::query()->updateOrCreate(
                ['id_kredit' => $kredit->id, 'angsuran_ke' => 2],
                [
                    'jatuh_tempo' => now()->subDays(3),
                    'jumlah_tagihan' => $angsuranPerBulan,
                    'jumlah_bayar' => 0,
                    'tanggal_bayar' => null,
                    'metode_bayar_id' => null,
                    'status' => 'tunggak',
                ]
            );

            Angsuran::query()->updateOrCreate(
                ['id_kredit' => $kredit->id, 'angsuran_ke' => 3],
                [
                    'jatuh_tempo' => now()->addDays(25),
                    'jumlah_tagihan' => $angsuranPerBulan,
                    'jumlah_bayar' => 0,
                    'tanggal_bayar' => null,
                    'metode_bayar_id' => null,
                    'status' => 'belum_bayar',
                ]
            );
        }
    }
}
