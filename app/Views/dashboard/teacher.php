<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Panel Guru / Wali Kelas</h2>
            <p class="text-xs text-slate-500">Pantau perkembangan siswa binaan dan evaluasi hasil pengisian jurnal harian.</p>
        </div>
        <a href="<?= base_url('/assessment/class-results') ?>" class="inline-flex items-center gap-1.5 px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg shadow-sm shadow-emerald-200 transition">
            <i data-lucide="clipboard-check" class="w-4 h-4"></i>
            <span>Buka Evaluasi Kelas</span>
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="p-5 bg-white border border-slate-200 rounded-2xl shadow-sm">
            <p class="text-xs font-medium text-slate-500">Siswa Binaan Kelas</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-1"><?= esc($totalStudents) ?> Siswa</h3>
        </div>
        <div class="p-5 bg-white border border-slate-200 rounded-2xl shadow-sm">
            <p class="text-xs font-medium text-slate-500">Jurnal Masuk Hari Ini</p>
            <h3 class="text-2xl font-bold text-emerald-600 mt-1"><?= esc($todayFilled) ?> / <?= esc($totalStudents) ?></h3>
        </div>
        <div class="p-5 bg-white border border-slate-200 rounded-2xl shadow-sm">
            <p class="text-xs font-medium text-slate-500">Tanggal Aktif</p>
            <h3 class="text-lg font-bold text-slate-700 mt-2"><?= date('d F Y') ?></h3>
        </div>
    </div>

    <!-- Kelas Binaan -->
    <div class="p-6 bg-white border border-slate-200 rounded-2xl shadow-sm">
        <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
            <i data-lucide="school" class="w-4 h-4 text-emerald-600"></i>
            Daftar Kelas Binaan Anda
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php foreach ($classes as $c): ?>
                <div class="p-4 border border-slate-200 rounded-xl flex items-center justify-between hover:border-emerald-300 transition">
                    <div>
                        <h4 class="text-sm font-bold text-slate-800"><?= esc($c['name']) ?></h4>
                        <span class="inline-block mt-1 text-[11px] font-medium px-2 py-0.5 rounded bg-slate-100 text-slate-600">
                            Jenjang: <?= esc($c['level']) ?>
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="<?= base_url('/assessment/class-results?class_id=' . $c['id']) ?>" class="px-3 py-1.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 rounded-lg text-xs font-semibold transition">
                            Lihat Rekap
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
