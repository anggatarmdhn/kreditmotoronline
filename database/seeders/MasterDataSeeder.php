<?php

namespace Database\Seeders;

use App\Models\JenisCicilan;
use App\Models\LandingSection;
use App\Models\Asuransi;
use App\Models\MetodeBayar;
use App\Models\Motor;
use App\Models\Pelanggan;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisCicilanRows = [
            ['nama' => 'Reguler 11 Bulan', 'tenor_bulan' => 11, 'bunga_persen' => 1.5, 'is_active' => true],
            ['nama' => 'Reguler 17 Bulan', 'tenor_bulan' => 17, 'bunga_persen' => 1.8, 'is_active' => true],
            ['nama' => 'Reguler 23 Bulan', 'tenor_bulan' => 23, 'bunga_persen' => 2.1, 'is_active' => true],
        ];

        foreach ($jenisCicilanRows as $row) {
            JenisCicilan::query()->updateOrCreate(['nama' => $row['nama']], $row);
        }

        MetodeBayar::query()->upsert([
            ['kode' => 'TRF', 'nama' => 'Transfer Bank', 'deskripsi' => 'Pembayaran melalui transfer bank', 'is_active' => true],
            ['kode' => 'CASH', 'nama' => 'Tunai', 'deskripsi' => 'Pembayaran langsung di kantor', 'is_active' => true],
            ['kode' => 'VA', 'nama' => 'Virtual Account', 'deskripsi' => 'Pembayaran melalui virtual account', 'is_active' => true],
        ], ['kode'], ['nama', 'deskripsi', 'is_active']);

        $asuransiRows = [
            [
                'nama_perusahaan' => 'Asuransi Aman Sentosa',
                'nama_asuransi' => 'Aman Basic',
                'margin_persen' => 0.75,
                'no_rekening' => '1234567890',
                'url_logo' => null,
                'is_active' => true,
            ],
            [
                'nama_perusahaan' => 'Asuransi Nusantara Proteksi',
                'nama_asuransi' => 'Nusantara Plus',
                'margin_persen' => 1.10,
                'no_rekening' => '0987654321',
                'url_logo' => null,
                'is_active' => true,
            ],
        ];

        foreach ($asuransiRows as $row) {
            Asuransi::query()->updateOrCreate(
                ['nama_asuransi' => $row['nama_asuransi']],
                $row
            );
        }

        $jenisMotorRows = [
            ['id' => 1, 'merk' => 'Honda', 'jenis' => 'Skuter', 'deskripsi_jenis' => 'Motor matic Honda yang lincah dan irit', 'image_url' => null],
            ['id' => 2, 'merk' => 'Yamaha', 'jenis' => 'Skuter', 'deskripsi_jenis' => 'Motor matic Yamaha premium', 'image_url' => null],
            ['id' => 3, 'merk' => 'Suzuki', 'jenis' => 'Sport Bike', 'deskripsi_jenis' => 'Motor sport bertenaga dari Suzuki', 'image_url' => null],
            ['id' => 4, 'merk' => 'Honda', 'jenis' => 'Sport Bike', 'deskripsi_jenis' => 'Motor sport performa tinggi Honda', 'image_url' => null],
            ['id' => 5, 'merk' => 'Yamaha', 'jenis' => 'Sport Bike', 'deskripsi_jenis' => 'Motor sport Yamaha berkarakter', 'image_url' => null],
        ];

        foreach ($jenisMotorRows as $row) {
            \App\Models\JenisMotor::query()->updateOrCreate(['id' => $row['id']], $row);
        }

        Motor::query()->upsert([
            [
                'kode_motor' => 'MTR-001',
                'nama_motor' => 'Beat CBS',
                'id_jenis' => 1,
                'warna' => 'Hitam',
                'kapasitas_mesin' => '110cc',
                'tahun_produksi' => 2025,
                'harga_cash' => 18500000,
                'harga_jual' => 18500000,
                'dp_minimum' => 2500000,
                'stok' => 12,
                'foto1' => 'motors/beat-cbs-1.jpg',
                'foto2' => 'motors/beat-cbs-2.jpeg',
                'foto3' => 'motors/beat-cbs-3.jpg',
                'deskripsi_motor' => 'Honda Beat irit dan gesit, cocok untuk harian di kota.',
                'is_active' => true,
            ],
            [
                'kode_motor' => 'MTR-002',
                'nama_motor' => 'NMAX 155',
                'id_jenis' => 2,
                'warna' => 'Silver',
                'kapasitas_mesin' => '155cc',
                'tahun_produksi' => 2025,
                'harga_cash' => 34500000,
                'harga_jual' => 34500000,
                'dp_minimum' => 5500000,
                'stok' => 8,
                'foto1' => 'motors/nmax-155-1.jpeg',
                'foto2' => 'motors/nmax-155-2.png',
                'foto3' => 'motors/nmax-155-3.jpeg',
                'deskripsi_motor' => 'Yamaha NMAX premium skuter dengan teknologi VVA.',
                'is_active' => true,
            ],
            [
                'kode_motor' => 'MTR-003',
                'nama_motor' => 'GSX R150',
                'id_jenis' => 3,
                'warna' => 'Biru',
                'kapasitas_mesin' => '150cc',
                'tahun_produksi' => 2025,
                'harga_cash' => 31250000,
                'harga_jual' => 31250000,
                'dp_minimum' => 5000000,
                'stok' => 5,
                'foto1' => 'motors/gsx-r150-1.png',
                'foto2' => null,
                'foto3' => null,
                'deskripsi_motor' => 'Suzuki GSX R150 performa sport tinggi.',
                'is_active' => true,
            ],
            [
                'kode_motor' => 'MTR-004',
                'nama_motor' => 'Vario 125',
                'id_jenis' => 1,
                'warna' => 'Merah',
                'kapasitas_mesin' => '125cc',
                'tahun_produksi' => 2025,
                'harga_cash' => 22500000,
                'harga_jual' => 22500000,
                'dp_minimum' => 3000000,
                'stok' => 10,
                'foto1' => 'motors/vario-125-1.jpg',
                'foto2' => 'motors/vario-125-2.jpg',
                'foto3' => 'motors/vario-125-3.jpeg',
                'deskripsi_motor' => 'Honda Vario 125 dengan fitur canggih dan bagasi luas.',
                'is_active' => true,
            ],
            [
                'kode_motor' => 'MTR-005',
                'nama_motor' => 'Aerox 155',
                'id_jenis' => 2,
                'warna' => 'Cyan',
                'kapasitas_mesin' => '155cc',
                'tahun_produksi' => 2025,
                'harga_cash' => 27500000,
                'harga_jual' => 27500000,
                'dp_minimum' => 4000000,
                'stok' => 7,
                'foto1' => 'motors/aerox-155-1.png',
                'foto2' => 'motors/aerox-155-2.png',
                'foto3' => 'motors/aerox-155-3.jpg',
                'deskripsi_motor' => 'Yamaha Aerox 155 sport scooter yang kencang dan stylish.',
                'is_active' => true,
            ],
            [
                'kode_motor' => 'MTR-006',
                'nama_motor' => 'Scoopy',
                'id_jenis' => 1,
                'warna' => 'Cream',
                'kapasitas_mesin' => '110cc',
                'tahun_produksi' => 2025,
                'harga_cash' => 21800000,
                'harga_jual' => 21800000,
                'dp_minimum' => 2800000,
                'stok' => 15,
                'foto1' => 'motors/scoopy-1.jpg',
                'foto2' => null,
                'foto3' => 'motors/scoopy-3.jpg',
                'deskripsi_motor' => 'Honda Scoopy desain retro modern yang ikonik.',
                'is_active' => true,
            ],
            [
                'kode_motor' => 'MTR-007',
                'nama_motor' => 'Mio M3',
                'id_jenis' => 2,
                'warna' => 'Biru',
                'kapasitas_mesin' => '125cc',
                'tahun_produksi' => 2025,
                'harga_cash' => 17400000,
                'harga_jual' => 17400000,
                'dp_minimum' => 2000000,
                'stok' => 20,
                'foto1' => 'motors/mio-m3-1.jpg',
                'foto2' => 'motors/mio-m3-2.png',
                'foto3' => null,
                'deskripsi_motor' => 'Yamaha Mio M3 motor harian yang handal dan ekonomis.',
                'is_active' => true,
            ],
            [
                'kode_motor' => 'MTR-008',
                'nama_motor' => 'CB150R',
                'id_jenis' => 4,
                'warna' => 'Hitam Merah',
                'kapasitas_mesin' => '150cc',
                'tahun_produksi' => 2025,
                'harga_cash' => 30500000,
                'harga_jual' => 30500000,
                'dp_minimum' => 4500000,
                'stok' => 4,
                'foto1' => 'motors/cb150r-1.png',
                'foto2' => 'motors/cb150r-2.jpg',
                'foto3' => 'motors/cb150r-3.png',
                'deskripsi_motor' => 'Honda CB150R StreetFire performa naked bike sejati.',
                'is_active' => true,
            ],
            [
                'kode_motor' => 'MTR-009',
                'nama_motor' => 'R15',
                'id_jenis' => 5,
                'warna' => 'Biru Putih',
                'kapasitas_mesin' => '155cc',
                'tahun_produksi' => 2025,
                'harga_cash' => 39800000,
                'harga_jual' => 39800000,
                'dp_minimum' => 6000000,
                'stok' => 3,
                'foto1' => 'motors/r15-1.png',
                'foto2' => 'motors/r15-2.jpeg',
                'foto3' => null,
                'deskripsi_motor' => 'Yamaha R15 motor sport dengan aura balap kental.',
                'is_active' => true,
            ],
        ], ['kode_motor'], ['nama_motor', 'id_jenis', 'warna', 'kapasitas_mesin', 'tahun_produksi', 'harga_cash', 'harga_jual', 'dp_minimum', 'stok', 'foto1', 'foto2', 'foto3', 'deskripsi_motor', 'is_active']);

        Pelanggan::query()->upsert([
            [
                'nama_pelanggan' => 'Budi Santoso',
                'nik' => '3273011201900001',
                'email' => 'budi@mail.com',
                'katakunci' => bcrypt('password123'),
                'no_telp' => '081234567890',
                'alamat1' => 'Jl. Merdeka No. 10',
                'kota1' => 'Bandung',
                'pekerjaan' => 'Karyawan Swasta',
                'penghasilan_bulanan' => 7000000,
                'status_pernikahan' => 'menikah',
            ],
            [
                'nama_pelanggan' => 'Siti Aisyah',
                'nik' => '3273011201900002',
                'email' => 'siti@mail.com',
                'katakunci' => bcrypt('password123'),
                'no_telp' => '081298765432',
                'alamat1' => 'Jl. Cempaka No. 5',
                'kota1' => 'Cimahi',
                'pekerjaan' => 'Wiraswasta',
                'penghasilan_bulanan' => 8500000,
                'status_pernikahan' => 'lajang',
            ],
        ], ['nik'], ['nama_pelanggan', 'email', 'katakunci', 'no_telp', 'alamat1', 'kota1', 'pekerjaan', 'penghasilan_bulanan', 'status_pernikahan']);

        LandingSection::query()->upsert([
            [
                'section_key' => 'hero',
                'title' => 'Kredit Motor Online Cepat dan Aman',
                'subtitle' => 'Persetujuan lebih cepat, proses transparan',
                'content' => 'Ajukan kredit motor secara online dengan simulasi cicilan yang jelas dan status pengajuan real-time.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'section_key' => 'benefit',
                'title' => 'Kenapa Pilih Kami?',
                'subtitle' => 'Layanan dirancang untuk kebutuhan harian',
                'content' => 'Bunga kompetitif, pilihan tenor fleksibel, dan dukungan tim marketing serta surveyor profesional.',
                'sort_order' => 2,
                'is_active' => true,
            ],
        ], ['section_key'], ['title', 'subtitle', 'content', 'sort_order', 'is_active']);
    }
}
