<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelaporan;
use App\Models\User;
use App\Models\LogAktivitas;
use App\Models\Notifikasi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class PelaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Dapatkan atau buat user pelapor
        $userUtama = User::where('role', 'user')->first();
        if (!$userUtama) {
            $userUtama = User::create([
                'name'     => 'Celino Matande',
                'email'    => 'celinomatande@gmail.com',
                'password' => Hash::make('password'),
                'role'     => 'user',
            ]);
        }

        $pelaporGuru = User::firstOrCreate(
            ['email' => 'ahmad.fauzi@sekolah.sch.id'],
            [
                'name'     => 'Ahmad Fauzi, S.Pd.',
                'password' => Hash::make('password'),
                'role'     => 'user',
            ]
        );

        $pelaporTU = User::firstOrCreate(
            ['email' => 'siti.nurhaliza@sekolah.sch.id'],
            [
                'name'     => 'Siti Nurhaliza',
                'password' => Hash::make('password'),
                'role'     => 'user',
            ]
        );

        $pelaporLab = User::firstOrCreate(
            ['email' => 'budi.santoso@sekolah.sch.id'],
            [
                'name'     => 'Budi Santoso (Laboran)',
                'password' => Hash::make('password'),
                'role'     => 'user',
            ]
        );

        // Dapatkan akun admin untuk pencatatan log aktivitas
        $admin = User::where('role', 'admin')->first();
        $adminId = $admin ? $admin->id : $userUtama->id;
        $adminName = $admin ? $admin->name : 'Administrator';

        // 2. Daftar data pelaporan sarpras realistis
        $dataPelaporan = [
            // --- STATUS: VERIFIKASI (5 Data) ---
            [
                'user'            => $userUtama,
                'sarana'          => 'Air Conditioner (AC) Daikin 2 PK',
                'lokasi'          => 'Lab Komputer 1, Gedung C Lantai 2',
                'deskripsi'       => 'Unit AC mengeluarkan suara dengungan keras dan hembusan udara tidak dingin sejak pagi hari. Mengganggu kenyamanan praktikum siswa.',
                'status'          => 'verifikasi',
                'catatan'         => null,
                'biaya_perbaikan' => null,
                'created_at'      => Carbon::now()->subHours(3),
            ],
            [
                'user'            => $pelaporGuru,
                'sarana'          => 'Proyektor Epson EB-E500',
                'lokasi'          => 'Ruang Kelas 12 MIPA 1',
                'deskripsi'       => 'Lampu indikator proyektor berkedip merah dan gambar tidak mau menyala saat dihubungkan ke laptop.',
                'status'          => 'verifikasi',
                'catatan'         => null,
                'biaya_perbaikan' => null,
                'created_at'      => Carbon::now()->subHours(6),
            ],
            [
                'user'            => $userUtama,
                'sarana'          => 'Kran Air Wastafel Stainless',
                'lokasi'          => 'Toilet Putra Lantai 1, Gedung Utama',
                'deskripsi'       => 'Kran air patah di bagian leher putaran sehingga air terus mengalir deras dan tidak bisa ditutup rapat.',
                'status'          => 'verifikasi',
                'catatan'         => null,
                'biaya_perbaikan' => null,
                'created_at'      => Carbon::now()->subDay(),
            ],
            [
                'user'            => $pelaporTU,
                'sarana'          => 'Printer Laser Multifungsi HP LaserJet',
                'lokasi'          => 'Ruang Tata Usaha (TU)',
                'deskripsi'       => 'Kertas selalu mengalami paper jam saat menarik lembaran kedua, disertai bunyi roda penarik kertas berderit.',
                'status'          => 'verifikasi',
                'catatan'         => null,
                'biaya_perbaikan' => null,
                'created_at'      => Carbon::now()->subDays(2),
            ],
            [
                'user'            => $pelaporLab,
                'sarana'          => 'Stop Kontak 4 Lubang Dinding',
                'lokasi'          => 'Bengkel Elektronika & Robotika',
                'deskripsi'       => 'Soket stop kontak mengalami korsleting ringan dan terlihat bekas hangus kehitaman, berbahaya jika tetap dialiri listrik.',
                'status'          => 'verifikasi',
                'catatan'         => null,
                'biaya_perbaikan' => null,
                'created_at'      => Carbon::now()->subDays(2)->addHours(4),
            ],

            // --- STATUS: DALAM PERBAIKAN (5 Data) ---
            [
                'user'            => $userUtama,
                'sarana'          => 'Kabel Jaringan LAN & Switch Hub 16 Port',
                'lokasi'          => 'Ruang Guru Gedung A',
                'deskripsi'       => 'Koneksi internet di sebagian meja guru terputus karena kabel LAN utama digigit tikus di atas plafon.',
                'status'          => 'dalam_perbaikan',
                'catatan'         => 'Teknisi jaringan sedang melakukan penarikan kabel UTP Cat6 baru dan crimping konektor RJ45.',
                'biaya_perbaikan' => 350000,
                'created_at'      => Carbon::now()->subDays(3),
            ],
            [
                'user'            => $pelaporGuru,
                'sarana'          => 'Kipas Angin Dinding Tornado Regenza',
                'lokasi'          => 'Ruang Kelas 10 IPS 3',
                'deskripsi'       => 'Kipas angin mati total saat pembelajaran berlangsung. Tercium bau sangit dari motor dinamo.',
                'status'          => 'dalam_perbaikan',
                'catatan'         => 'Dinamo kipas terbakar, sedang proses pemesanan unit dinamo cadangan ke rekanan toko elektronik.',
                'biaya_perbaikan' => 175000,
                'created_at'      => Carbon::now()->subDays(4),
            ],
            [
                'user'            => $userUtama,
                'sarana'          => 'Pintu Utama Kayu & Handle Kunci',
                'lokasi'          => 'Perpustakaan Utama Lantai 2',
                'deskripsi'       => 'Kunci silinder macet dan engsel pintu bawah kendur sehingga daun pintu bergesekan dengan lantai keramik.',
                'status'          => 'dalam_perbaikan',
                'catatan'         => 'Sedang ditangani oleh tukang kayu sekolah: penggantian engsel stainless heavy-duty dan silinder kunci baru.',
                'biaya_perbaikan' => 220000,
                'created_at'      => Carbon::now()->subDays(5),
            ],
            [
                'user'            => $pelaporLab,
                'sarana'          => 'Mikroskop Binokuler Olympus',
                'lokasi'          => 'Laboratorium Biologi',
                'deskripsi'       => 'Lensa okuler buram berjamur dan sekrup pengatur fokus kasar (makrometer) longgar tidak mau mencengkeram.',
                'status'          => 'dalam_perbaikan',
                'catatan'         => 'Unit dibawa oleh tim servis optik spesialis alat lab untuk pembersihan jamur (cleaning optic) dan kalibrasi sekrup.',
                'biaya_perbaikan' => 450000,
                'created_at'      => Carbon::now()->subDays(6),
            ],
            [
                'user'            => $pelaporTU,
                'sarana'          => 'Plafon Gypsum & Talang Air',
                'lokasi'          => 'Selasar Koridor Lantai 2 Dekat Ruang UKS',
                'deskripsi'       => 'Plafon rembes akibat kebocoran talang seng saat hujan deras, sebagian gypsum sudah melengkung dan rawan runtuh.',
                'status'          => 'dalam_perbaikan',
                'catatan'         => 'Pekerjaan perbaikan talang atap seng dan penambalan seal karet sedang berjalan sebelum penggantian papan gypsum baru.',
                'biaya_perbaikan' => 650000,
                'created_at'      => Carbon::now()->subDays(7),
            ],

            // --- STATUS: SELESAI (6 Data) ---
            [
                'user'            => $userUtama,
                'sarana'          => 'Pompa Air Sumur Dangkal Shimizu',
                'lokasi'          => 'Kantin Sekolah & Taman Belakang',
                'deskripsi'       => 'Otomatis pressure switch pompa air rusak sehingga pompa terus menyala tanpa henti dan pipa saluran air panas.',
                'status'          => 'selesai',
                'catatan'         => 'Telah diganti dengan pressure switch otomatis baru merek San-Ei dan instalasi kabel kontrol diperbaiki. Aliran air kembali lancar dan aman.',
                'biaya_perbaikan' => 280000,
                'created_at'      => Carbon::now()->subDays(10),
            ],
            [
                'user'            => $pelaporGuru,
                'sarana'          => 'Papan Tulis Whiteboard Magnetik 120x240 cm',
                'lokasi'          => 'Ruang Kelas 11 IPA 3',
                'deskripsi'       => 'Kait gantung papan tulis patah di sisi kanan sehingga miring dan membahayakan siswa di barisan depan.',
                'status'          => 'selesai',
                'catatan'         => 'Pemasangan dynabolt dan braket siku besi baru di kedua sisi dinding. Posisi papan tulis sudah kokoh dan rata horizontal.',
                'biaya_perbaikan' => 85000,
                'created_at'      => Carbon::now()->subDays(12),
            ],
            [
                'user'            => $userUtama,
                'sarana'          => 'Lampu LED Tube Philips 18 Watt (4 Unit)',
                'lokasi'          => 'Ruang Rapat Utama Gedung Rektorat/Pimpinan',
                'deskripsi'       => 'Dua lampu penerangan mati total dan dua lainnya berkedip-kedip cepat (flicker).',
                'status'          => 'selesai',
                'catatan'         => 'Seluruh 4 unit lampu tabung LED telah diganti baru berspesifikasi Philips Master LED Tube 18W Cool Daylight.',
                'biaya_perbaikan' => 320000,
                'created_at'      => Carbon::now()->subDays(15),
            ],
            [
                'user'            => $pelaporLab,
                'sarana'          => 'PC Komputer Siswa Core i5 (Unit PC-08)',
                'lokasi'          => 'Lab Rekayasa Perangkat Lunak',
                'deskripsi'       => 'Komputer sering mati mendadak (restart sendiri) saat menjalankan aplikasi Android Studio.',
                'status'          => 'selesai',
                'catatan'         => 'Penggantian Power Supply Unit (PSU FSP 500W 80+) baru dan pembersihan debu heatsink prosesor serta repaste thermal grease Arctic MX-4.',
                'biaya_perbaikan' => 580000,
                'created_at'      => Carbon::now()->subDays(18),
            ],
            [
                'user'            => $pelaporTU,
                'sarana'          => 'Pintu Pagar Besi Geser (Sliding Gate)',
                'lokasi'          => 'Gerbang Parkir Kendaraan Guru & Karyawan',
                'deskripsi'       => 'Roda rel pintu pagar anjlok keluar lintasan dan berkarat parah sehingga sulit didorong oleh satpam.',
                'status'          => 'selesai',
                'catatan'         => 'Penggantian sepasang roda bearing ganda diameter 8 cm, pelurusan rel besi siku, dan pelumasan gemuk grease tahan air.',
                'biaya_perbaikan' => 420000,
                'created_at'      => Carbon::now()->subDays(22),
            ],
            [
                'user'            => $userUtama,
                'sarana'          => 'Kaca Jendela Nako & Kusen Aluminium',
                'lokasi'          => 'Ruang Bimbingan Konseling (BK)',
                'deskripsi'       => 'Satu bilah kaca nako pecah akibat terbentur bola futsal nyasar dari lapangan tengah.',
                'status'          => 'selesai',
                'catatan'         => 'Pemasangan kaca nako bening tebal 5 mm baru dan pengecekan klip pengunci kusen aluminium.',
                'biaya_perbaikan' => 65000,
                'created_at'      => Carbon::now()->subDays(25),
            ],
        ];

        // 3. Masukkan ke database bersama log aktivitas & notifikasi
        foreach ($dataPelaporan as $item) {
            $user = $item['user'];

            $pelaporan = Pelaporan::create([
                'user_id'         => $user->id,
                'sarana'          => $item['sarana'],
                'lokasi'          => $item['lokasi'],
                'deskripsi'       => $item['deskripsi'],
                'bukti'           => null,
                'status'          => $item['status'],
                'catatan'         => $item['catatan'],
                'biaya_perbaikan' => $item['biaya_perbaikan'],
                'created_at'      => $item['created_at'],
                'updated_at'      => $item['created_at'],
            ]);

            // Log awal saat pelaporan dibuat
            LogAktivitas::create([
                'pelaporan_id' => $pelaporan->id,
                'user_id'      => $user->id,
                'aktivitas'    => 'Laporan diajukan oleh ' . $user->name,
                'created_at'   => $item['created_at'],
                'updated_at'   => $item['created_at'],
            ]);

            // Log & Notifikasi tambahan jika status dalam_perbaikan atau selesai
            if ($item['status'] === 'dalam_perbaikan') {
                $waktuProses = (clone $item['created_at'])->addHours(4);

                LogAktivitas::create([
                    'pelaporan_id' => $pelaporan->id,
                    'user_id'      => $adminId,
                    'aktivitas'    => 'Status diubah dari "verifikasi" menjadi "dalam perbaikan" oleh ' . $adminName,
                    'created_at'   => $waktuProses,
                    'updated_at'   => $waktuProses,
                ]);

                if ($item['biaya_perbaikan']) {
                    LogAktivitas::create([
                        'pelaporan_id' => $pelaporan->id,
                        'user_id'      => $adminId,
                        'aktivitas'    => 'Estimasi biaya perbaikan ditetapkan Rp ' . number_format($item['biaya_perbaikan'], 0, ',', '.') . ' oleh ' . $adminName,
                        'created_at'   => $waktuProses->addMinutes(5),
                        'updated_at'   => $waktuProses,
                    ]);
                }

                Notifikasi::create([
                    'user_id'      => $user->id,
                    'pelaporan_id' => $pelaporan->id,
                    'pesan'        => "Laporan sarana '{$item['sarana']}' sedang dalam proses perbaikan oleh tim sarpras.",
                    'is_read'      => false,
                    'created_at'   => $waktuProses,
                    'updated_at'   => $waktuProses,
                ]);
            }

            if ($item['status'] === 'selesai') {
                $waktuProses = (clone $item['created_at'])->addDays(1);
                $waktuSelesai = (clone $item['created_at'])->addDays(2);

                LogAktivitas::create([
                    'pelaporan_id' => $pelaporan->id,
                    'user_id'      => $adminId,
                    'aktivitas'    => 'Status diubah dari "verifikasi" menjadi "dalam perbaikan" oleh ' . $adminName,
                    'created_at'   => $waktuProses,
                    'updated_at'   => $waktuProses,
                ]);

                LogAktivitas::create([
                    'pelaporan_id' => $pelaporan->id,
                    'user_id'      => $adminId,
                    'aktivitas'    => 'Perbaikan selesai dilaksanakan. Total biaya Rp ' . number_format($item['biaya_perbaikan'], 0, ',', '.') . ' oleh ' . $adminName,
                    'created_at'   => $waktuSelesai,
                    'updated_at'   => $waktuSelesai,
                ]);

                Notifikasi::create([
                    'user_id'      => $user->id,
                    'pelaporan_id' => $pelaporan->id,
                    'pesan'        => "Laporan sarana '{$item['sarana']}' telah selesai diperbaiki dan siap digunakan kembali.",
                    'is_read'      => true,
                    'created_at'   => $waktuSelesai,
                    'updated_at'   => $waktuSelesai,
                ]);
            }
        }
    }
}
