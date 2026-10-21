<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Daftar Rombongan Belajar (Kelas)</h2>
            <p class="text-xs text-slate-500">Kelola kelompok kelas dan penugasan wali kelas.</p>
        </div>
        <a href="<?= base_url('/classes/create') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl shadow-sm shadow-emerald-200 transition">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Kelas</span>
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <th class="py-3 px-4 font-semibold">Nama Kelas</th>
                        <th class="py-3 px-4 font-semibold">Tingkat / Jenjang</th>
                        <th class="py-3 px-4 font-semibold">Tahun Ajaran</th>
                        <th class="py-3 px-4 font-semibold">Wali Kelas</th>
                        <th class="py-3 px-4 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($classes as $c): ?>
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3 px-4 font-bold text-slate-800"><?= esc($c['name']) ?></td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700">
                                    <?= esc($c['level']) ?>
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-600 font-medium"><?= esc($c['academic_year_name']) ?></td>
                            <td class="py-3 px-4 font-medium text-slate-800">
                                <?= esc($c['homeroom_teacher_name'] ?? 'Belum ditentukan') ?>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <a href="<?= base_url('/assessment/class-results?class_id=' . $c['id']) ?>" class="text-xs font-semibold text-emerald-600 hover:underline">
                                    Lihat Evaluasi
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
