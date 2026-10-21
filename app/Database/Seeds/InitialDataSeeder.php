<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $now = date('Y-m-d H:i:s');

        // 1. School Profile
        $db->table('school_profiles')->insert([
            'school_name'    => 'TK Islam Terpadu Mas Anis',
            'npsn'           => '69912345',
            'address'        => 'Jl. Pendidikan Karakter No. 10',
            'phone'          => '081234567890',
            'email'          => 'tk.masanis@example.sch.id',
            'principal_name' => 'Hj. Siti Aminah, S.Pd.I',
            'logo'           => null,
            'created_at'     => $now,
            'updated_at'     => $now,
        ]);

        // 2. Academic Year
        $db->table('academic_years')->insert([
            'name'       => '2026/2027',
            'semester'   => '1',
            'is_active'  => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $academicYearId = $db->insertID();

        // 3. Evaluation Pillars & 18 Indicators (Persis dari Excel)
        $pillars = [
            'Spiritual' => [
                [
                    'name'    => 'Shalat Subuh tepat waktu / belajar ikut tanpa drama',
                    'score_2' => '2: Tepat waktu/Ceria',
                    'score_1' => '1: Kesiangan/Drama',
                    'score_0' => '0: Belum mau',
                ],
                [
                    'name'    => 'Shalat Dzuhur tepat waktu / mau diajak shalat berjamaah',
                    'score_2' => '2: Mau diajak/Ceria',
                    'score_1' => '1: Diingatkan berkali-kali',
                    'score_0' => '0: Belum mau',
                ],
                [
                    'name'    => 'Shalat Ashar tepat waktu / mau diajak shalat berjamaah',
                    'score_2' => '2: Mau diajak/Ceria',
                    'score_1' => '1: Diingatkan berkali-kali',
                    'score_0' => '0: Belum mau',
                ],
                [
                    'name'    => 'Shalat Maghrib tepat waktu / mau diajak shalat berjamaah',
                    'score_2' => '2: Mau diajak/Ceria',
                    'score_1' => '1: Diingatkan berkali-kali',
                    'score_0' => '0: Belum mau',
                ],
                [
                    'name'    => 'Shalat Isya tepat waktu / mau diajak shalat berjamaah',
                    'score_2' => '2: Mau diajak/Ceria',
                    'score_1' => '1: Diingatkan berkali-kali',
                    'score_0' => '0: Belum mau',
                ],
            ],
            'Fisik & Motorik' => [
                [
                    'name'    => 'Olahraga Pagi (senam/jalan/sepeda/fisik aktif)',
                    'score_2' => '2: Bergerak aktif/Ceria',
                    'score_1' => '1: Hanya sebentar/Kurang semangat',
                    'score_0' => '0: Malas bergerak',
                ],
                [
                    'name'    => 'Bermain Fisik Aktif Sore (bukan main gadget/HP)',
                    'score_2' => '2: Main luar rumah/Fisik',
                    'score_1' => '1: Main di dalam rumah saja',
                    'score_0' => '0: Full main HP/Gadget',
                ],
            ],
            'Kemandirian' => [
                [
                    'name'    => 'Bangun Tidur Pagi tanpa rewel',
                    'score_2' => '2: Bangun ceria & segar',
                    'score_1' => '1: Merengek sebentar',
                    'score_0' => '0: Mengamuk/Tantrum lama',
                ],
                [
                    'name'    => 'Perawatan Diri Pagi (mandi, sikat gigi, pakai baju sendiri)',
                    'score_2' => '2: Mandi & bersiap sendiri',
                    'score_1' => '1: Dibantu setengahnya',
                    'score_0' => '0: Dibantu total/Drama',
                ],
                [
                    'name'    => 'Sarapan Pagi dengan tertib & mandiri',
                    'score_2' => '2: Habis & makan sendiri sambil duduk',
                    'score_1' => '1: Disuapi sebagian',
                    'score_0' => '0: Disuapi total/Sambil HP',
                ],
                [
                    'name'    => 'Merapikan kembali mainan atau buku yang selesai digunakan',
                    'score_2' => '2: Inisiatif sendiri merapikan',
                    'score_1' => '1: Harus disuruh berkali-kali',
                    'score_0' => '0: Menolak/Ditinggal berantakan',
                ],
                [
                    'name'    => 'Adab Pulang Rumah (ucap salam, taruh sepatu & tas sendiri)',
                    'score_2' => '2: Salam & taruh barang dengan rapi',
                    'score_1' => '1: Harus diingatkan',
                    'score_0' => '0: Barang dilempar acak-acakan',
                ],
                [
                    'name'    => 'Persiapan Tidur Malam (sikat gigi & baca doa tidur)',
                    'score_2' => '2: Sikat gigi & doa mandiri',
                    'score_1' => '1: Harus dipaksa/Dikejar dulu',
                    'score_0' => '0: Langsung tidur tanpa sikat',
                ],
            ],
            'Adab & Sosial' => [
                [
                    'name'    => 'Penggunaan 3 Kata Sakti (Maaf, Tolong, Terima Kasih)',
                    'score_2' => '2: Spontan mengucapkan',
                    'score_1' => '1: Ucap jika diingatkan',
                    'score_0' => '0: Tidak mau mengucapkan',
                ],
                [
                    'name'    => 'Mau Berbagi di rumah (berbagi makanan/mainan ke saudara)',
                    'score_2' => '2: Mau berbagi dengan ceria',
                    'score_1' => '1: Berbagi setelah dibujuk',
                    'score_0' => '0: Pelit/Merebut mainan',
                ],
                [
                    'name'    => 'Nada Bicara & Sopan Santun',
                    'score_2' => '2: Sopan & suara lembut',
                    'score_1' => '1: Berteriak karena gemas/kesal',
                    'score_0' => '0: Membentak/Kasar',
                ],
            ],
            'Emosi' => [
                [
                    'name'    => 'Pengendalian Rasa Kecewa (keinginan ditolak/tidak dituruti)',
                    'score_2' => '2: Menangis wajar/Bisa ditenangkan',
                    'score_1' => '1: Merengek lama',
                    'score_0' => '0: Mengamuk/Pukul/Tantrum hebat',
                ],
                [
                    'name'    => 'Kejujuran & Tanggung Jawab',
                    'score_2' => '2: Jujur berani mengakui kesalahan',
                    'score_1' => '1: Ragu-ragu/Takut jujur',
                    'score_0' => '0: Berbohong',
                ],
            ],
        ];

        $pNum = 1;
        $iNum = 1;
        foreach ($pillars as $pillarName => $indicators) {
            $db->table('evaluation_pillars')->insert([
                'name'      => $pillarName,
                'order_num' => $pNum++,
            ]);
            $pillarId = $db->insertID();

            foreach ($indicators as $ind) {
                $db->table('evaluation_indicators')->insert([
                    'pillar_id'     => $pillarId,
                    'code'          => 'IND-' . str_pad($iNum, 2, '0', STR_PAD_LEFT),
                    'name'          => $ind['name'],
                    'guide_score_2' => $ind['score_2'],
                    'guide_score_1' => $ind['score_1'],
                    'guide_score_0' => $ind['score_0'],
                    'order_num'     => $iNum++,
                    'is_active'     => 1,
                ]);
            }
        }

        // 4. Default Admin User (username: admin, pass: admin123)
        $defaultPassword = password_hash('admin123', PASSWORD_BCRYPT);
        $db->table('users')->insert([
            'username'      => 'admin',
            'password_hash' => $defaultPassword,
            'role'          => 'admin',
            'name'          => 'Administrator Sistem',
            'phone'         => '081234567890',
            'email'         => 'admin@masanis.sch.id',
            'is_active'     => 1,
            'created_at'    => $now,
            'updated_at'    => $now,
        ]);

        // 5. Sample Teacher (username: guru1, pass: guru123)
        $teacherPassword = password_hash('guru123', PASSWORD_BCRYPT);
        $db->table('users')->insert([
            'username'      => 'guru1',
            'password_hash' => $teacherPassword,
            'role'          => 'teacher',
            'name'          => 'Ustadzah Fatimah, S.Pd',
            'phone'         => '081298765432',
            'email'         => 'fatimah@masanis.sch.id',
            'is_active'     => 1,
            'created_at'    => $now,
            'updated_at'    => $now,
        ]);
        $teacherUserId = $db->insertID();

        $db->table('teachers')->insert([
            'user_id'    => $teacherUserId,
            'nip'        => '199008152018012001',
            'full_name'  => 'Ustadzah Fatimah, S.Pd',
            'gender'     => 'P',
            'phone'      => '081298765432',
            'address'    => 'Jl. Anggrek No. 12',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $teacherId = $db->insertID();

        // 6. Sample Classes
        $db->table('classes')->insert([
            'academic_year_id' => $academicYearId,
            'name'             => 'TK-A Khadijah',
            'level'            => 'TK-A',
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        $classAId = $db->insertID();

        $db->table('classes')->insert([
            'academic_year_id' => $academicYearId,
            'name'             => 'TK-B Aisyah',
            'level'            => 'TK-B',
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);

        // Assign Wali Kelas
        $db->table('class_teachers')->insert([
            'class_id'    => $classAId,
            'teacher_id'  => $teacherId,
            'is_homeroom' => 1,
        ]);

        // 7. Sample Parent & Student (Login NIS: 2026001 / HP: 081211112222, pass: siswa123)
        $parentPassword = password_hash('siswa123', PASSWORD_BCRYPT);
        $db->table('users')->insert([
            'username'      => '2026001', // NIS juga sebagai username
            'password_hash' => $parentPassword,
            'role'          => 'parent',
            'name'          => 'Ahmad Zaki (Ortu: Bpk. Ridwan)',
            'phone'         => '081211112222',
            'email'         => 'ridwan@example.com',
            'is_active'     => 1,
            'created_at'    => $now,
            'updated_at'    => $now,
        ]);
        $studentUserId = $db->insertID();

        $db->table('students')->insert([
            'user_id'      => $studentUserId,
            'class_id'     => $classAId,
            'nis'          => '2026001',
            'nisn'         => '0192837465',
            'full_name'    => 'Ahmad Zaki Al-Farizi',
            'nickname'     => 'Zaki',
            'gender'       => 'L',
            'birth_place'  => 'Jakarta',
            'birth_date'   => '2021-05-14',
            'parent_name'  => 'M. Ridwan',
            'parent_phone' => '081211112222',
            'address'      => 'Jl. Melati Indah No. 5',
            'created_at'   => $now,
            'updated_at'   => $now,
        ]);
    }
}
