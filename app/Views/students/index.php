<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Data Siswa</h2>
            <p class="text-xs text-slate-500">Daftar siswa TK yang terdaftar dan akun login orang tua.</p>
        </div>
        <a href="<?= base_url('/students/create') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl shadow-sm shadow-emerald-200 transition">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            <span>Tambah Siswa</span>
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <th class="py-3 px-4 font-semibold">NIS</th>
                        <th class="py-3 px-4 font-semibold">Nama Lengkap</th>
                        <th class="py-3 px-4 font-semibold">Kelas</th>
                        <th class="py-3 px-4 font-semibold">Nama Orang Tua</th>
                        <th class="py-3 px-4 font-semibold">No. HP (Login Ortu)</th>
                        <th class="py-3 px-4 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($students as $s): ?>
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3 px-4 font-mono font-bold text-slate-800"><?= esc($s['nis']) ?></td>
                            <td class="py-3 px-4 font-bold text-slate-800">
                                <div><?= esc($s['full_name']) ?></div>
                                <span class="text-[10px] text-slate-400">Panggilan: <?= esc($s['nickname'] ?? '-') ?> &bull; <?= $s['gender'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-700">
                                    <?= esc($s['class_name']) ?> (<?= esc($s['class_level']) ?>)
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-700"><?= esc($s['parent_name']) ?></td>
                            <td class="py-3 px-4 font-mono text-emerald-600 font-semibold"><?= esc($s['parent_phone']) ?></td>
                            <td class="py-3 px-4 text-right space-x-2">
                                <a href="<?= base_url('/assessment/daily/' . $s['id']) ?>" class="text-emerald-600 hover:underline font-semibold">
                                    Input Jurnal
                                </a>
                                <a href="<?= base_url('/assessment/student/' . $s['id'] . '/yearly') ?>" class="text-slate-600 hover:underline font-semibold">
                                    Raport
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
