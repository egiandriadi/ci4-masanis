<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Data Guru & Tenaga Pendidik</h2>
            <p class="text-xs text-slate-500">Daftar guru pengajar dan wali kelas.</p>
        </div>
        <a href="<?= base_url('/teachers/create') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl shadow-sm shadow-emerald-200 transition">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            <span>Tambah Guru</span>
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <th class="py-3 px-4 font-semibold">Nama Lengkap & Gelar</th>
                        <th class="py-3 px-4 font-semibold">NIP</th>
                        <th class="py-3 px-4 font-semibold">Username Login</th>
                        <th class="py-3 px-4 font-semibold">Jenis Kelamin</th>
                        <th class="py-3 px-4 font-semibold">No. HP</th>
                        <th class="py-3 px-4 font-semibold">Status Akun</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($teachers as $t): ?>
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3 px-4 font-bold text-slate-800"><?= esc($t['full_name']) ?></td>
                            <td class="py-3 px-4 font-mono text-slate-600"><?= esc($t['nip'] ?? '-') ?></td>
                            <td class="py-3 px-4 font-mono font-semibold text-emerald-600"><?= esc($t['username']) ?></td>
                            <td class="py-3 px-4"><?= $t['gender'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                            <td class="py-3 px-4 font-mono text-slate-600"><?= esc($t['phone'] ?? '-') ?></td>
                            <td class="py-3 px-4">
                                <?php if ($t['is_active']): ?>
                                    <span class="inline-flex items-center gap-1 text-[11px] text-emerald-600 font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 text-[11px] text-rose-500 font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Nonaktif
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
