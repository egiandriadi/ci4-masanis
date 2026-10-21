<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Ringkasan Sistem</h2>
            <p class="text-xs text-slate-500">Kelola master data sekolah, guru, kelas, dan pantau aktivitas jurnal harian anak.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="<?= base_url('/assessment/class-results') ?>" class="inline-flex items-center gap-1.5 px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg shadow-sm shadow-emerald-200 transition">
                <i data-lucide="clipboard-list" class="w-4 h-4"></i>
                <span>Lihat Rekap Kelas</span>
            </a>
            <a href="<?= base_url('/users/create') ?>" class="inline-flex items-center gap-1.5 px-3 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs font-semibold rounded-lg shadow-sm transition">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span>Tambah Pengguna</span>
            </a>
        </div>
    </div>

    <!-- Metric Cards (Shadcn style) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Siswa -->
        <div class="p-5 bg-white border border-slate-200 rounded-2xl shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500">Total Siswa Aktif</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1"><?= esc($totalStudents) ?></h3>
                <span class="text-[11px] text-emerald-600 font-medium">Terdaftar di kelas</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
        </div>

        <!-- Guru -->
        <div class="p-5 bg-white border border-slate-200 rounded-2xl shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500">Total Tenaga Pendidik</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1"><?= esc($totalTeachers) ?></h3>
                <span class="text-[11px] text-slate-500">Wali kelas & guru</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i data-lucide="graduation-cap" class="w-6 h-6"></i>
            </div>
        </div>

        <!-- Rombel / Kelas -->
        <div class="p-5 bg-white border border-slate-200 rounded-2xl shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500">Rombongan Belajar</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1"><?= esc($totalClasses) ?></h3>
                <span class="text-[11px] text-slate-500">TK-A & TK-B</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                <i data-lucide="school" class="w-6 h-6"></i>
            </div>
        </div>

        <!-- Jurnal Hari Ini -->
        <div class="p-5 bg-white border border-slate-200 rounded-2xl shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500">Jurnal Hari Ini</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1"><?= esc($todayAssessments) ?></h3>
                <span class="text-[11px] text-emerald-600 font-medium"><?= date('d M Y') ?></span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <i data-lucide="check-circle-2" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <!-- Quick Navigation Panels -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="p-6 bg-white border border-slate-200 rounded-2xl shadow-sm space-y-4">
            <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                <i data-lucide="sliders" class="w-4 h-4 text-emerald-600"></i>
                Akses Cepat Pengelolaan
            </h4>
            <div class="grid grid-cols-2 gap-3">
                <a href="<?= base_url('/students/create') ?>" class="p-3 rounded-xl border border-slate-200 hover:border-emerald-300 hover:bg-emerald-50/40 transition group">
                    <p class="text-xs font-semibold text-slate-800 group-hover:text-emerald-700">+ Tambah Siswa</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">Buat otomatis akun ortu</p>
                </a>
                <a href="<?= base_url('/teachers/create') ?>" class="p-3 rounded-xl border border-slate-200 hover:border-emerald-300 hover:bg-emerald-50/40 transition group">
                    <p class="text-xs font-semibold text-slate-800 group-hover:text-emerald-700">+ Tambah Guru</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">Buat akun login pendidik</p>
                </a>
                <a href="<?= base_url('/classes/create') ?>" class="p-3 rounded-xl border border-slate-200 hover:border-emerald-300 hover:bg-emerald-50/40 transition group">
                    <p class="text-xs font-semibold text-slate-800 group-hover:text-emerald-700">+ Tambah Kelas</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">Plot wali kelas</p>
                </a>
                <a href="<?= base_url('/pillars') ?>" class="p-3 rounded-xl border border-slate-200 hover:border-emerald-300 hover:bg-emerald-50/40 transition group">
                    <p class="text-xs font-semibold text-slate-800 group-hover:text-emerald-700">Setup Kategori (Pilar)</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">Kelola aspek perkembangan</p>
                </a>
                <a href="<?= base_url('/indicators') ?>" class="p-3 rounded-xl border border-slate-200 hover:border-emerald-300 hover:bg-emerald-50/40 transition group">
                    <p class="text-xs font-semibold text-slate-800 group-hover:text-emerald-700">Setup Indikator & Rubrik</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">Ubah / tambah deskripsi rubrik</p>
                </a>
                <a href="<?= base_url('/school/profile') ?>" class="p-3 rounded-xl border border-slate-200 hover:border-emerald-300 hover:bg-emerald-50/40 transition group">
                    <p class="text-xs font-semibold text-slate-800 group-hover:text-emerald-700">Profil Sekolah</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">Ubah identitas & NPSN</p>
                </a>
            </div>
        </div>

        <div class="p-6 bg-white border border-slate-200 rounded-2xl shadow-sm space-y-4">
            <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                <i data-lucide="book-open" class="w-4 h-4 text-emerald-600"></i>
                Instrumen 18 Indikator (Excel Terintegrasi)
            </h4>
            <p class="text-xs text-slate-500 leading-relaxed">
                Instrumen terbagi dalam 5 Pilar: <strong>Spiritual, Fisik & Motorik, Kemandirian, Adab & Sosial, Emosi</strong>. Rata-rata harian (skala 0 - 2.0) diklasifikasikan secara otomatis ke kategori:
            </p>
            <div class="grid grid-cols-2 gap-2 text-xs">
                <div class="p-2.5 rounded-lg bg-emerald-50 border border-emerald-100 flex items-center justify-between">
                    <span class="font-bold text-emerald-700">BSB (1.63 - 2.00)</span>
                    <span class="text-[10px] text-emerald-600">Sangat Baik</span>
                </div>
                <div class="p-2.5 rounded-lg bg-blue-50 border border-blue-100 flex items-center justify-between">
                    <span class="font-bold text-blue-700">BSH (1.26 - 1.62)</span>
                    <span class="text-[10px] text-blue-600">Sesuai Harapan</span>
                </div>
                <div class="p-2.5 rounded-lg bg-amber-50 border border-amber-100 flex items-center justify-between">
                    <span class="font-bold text-amber-700">MB (0.76 - 1.25)</span>
                    <span class="text-[10px] text-amber-600">Mulai Berkembang</span>
                </div>
                <div class="p-2.5 rounded-lg bg-rose-50 border border-rose-100 flex items-center justify-between">
                    <span class="font-bold text-rose-700">BB (0.00 - 0.75)</span>
                    <span class="text-[10px] text-rose-600">Belum Berkembang</span>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
