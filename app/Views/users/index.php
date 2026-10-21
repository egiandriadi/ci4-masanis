<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Manajemen Pengguna</h2>
            <p class="text-xs text-slate-500">Kelola akun administrator, tenaga pendidik (guru), dan orang tua siswa.</p>
        </div>
        <a href="<?= base_url('/users/create') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl shadow-sm shadow-emerald-200 transition">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            <span>Tambah Pengguna</span>
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <th class="py-3 px-4 font-semibold">Nama Lengkap</th>
                        <th class="py-3 px-4 font-semibold">Username / Login</th>
                        <th class="py-3 px-4 font-semibold">Peran</th>
                        <th class="py-3 px-4 font-semibold">No. HP</th>
                        <th class="py-3 px-4 font-semibold">Status</th>
                        <th class="py-3 px-4 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($users as $u): ?>
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3 px-4 font-bold text-slate-800"><?= esc($u['name']) ?></td>
                            <td class="py-3 px-4 font-mono text-slate-600"><?= esc($u['username']) ?></td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase
                                    <?= $u['role'] === 'admin' ? 'bg-purple-100 text-purple-800' : 
                                       ($u['role'] === 'teacher' ? 'bg-blue-100 text-blue-800' : 'bg-emerald-100 text-emerald-800') ?>">
                                    <?= esc($u['role']) ?>
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-600 font-mono"><?= esc($u['phone'] ?? '-') ?></td>
                            <td class="py-3 px-4">
                                <?php if ($u['is_active']): ?>
                                    <span class="inline-flex items-center gap-1 text-[11px] text-emerald-600 font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 text-[11px] text-rose-500 font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Nonaktif
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <a href="<?= base_url('/users/toggle/' . $u['id']) ?>" 
                                   class="text-xs font-semibold <?= $u['is_active'] ? 'text-rose-600 hover:text-rose-700' : 'text-emerald-600 hover:text-emerald-700' ?>">
                                    <?= $u['is_active'] ? 'Nonaktifkan' : 'Aktifkan' ?>
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
