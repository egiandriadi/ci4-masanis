<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Header with Filter -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Setup Instrumen Indikator & Rubrik</h2>
            <p class="text-xs text-slate-500">Kelola 18 indikator perkembangan anak dan panduan penilaian skor 2, 1, 0.</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <!-- Filter by Pillar -->
            <form method="GET" class="flex items-center gap-2">
                <select name="pillar_id" onchange="this.form.submit()"
                        class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white">
                    <option value="">-- Semua Kategori Pilar --</option>
                    <?php foreach ($pillars as $p): ?>
                        <option value="<?= $p['id'] ?>" <?= $p['id'] == $selectedPillarId ? 'selected' : '' ?>>
                            Pilar <?= esc($p['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>

            <a href="<?= base_url('/indicators/create') ?>" 
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl shadow-sm shadow-emerald-200 transition">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Tambah Indikator</span>
            </a>
        </div>
    </div>

    <!-- Indicators Table -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <th class="py-3 px-4 font-semibold">Kode</th>
                        <th class="py-3 px-4 font-semibold">Pilar</th>
                        <th class="py-3 px-4 font-semibold">Aktivitas Indikator</th>
                        <th class="py-3 px-4 font-semibold">Rubrik Skor (2 / 1 / 0)</th>
                        <th class="py-3 px-4 font-semibold">Status</th>
                        <th class="py-3 px-4 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($indicators as $ind): ?>
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-4 font-mono font-bold text-slate-700"><?= esc($ind['code'] ?: 'IND') ?></td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-800">
                                    <?= esc($ind['pillar_name']) ?>
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-800 max-w-xs">
                                <?= esc($ind['name']) ?>
                            </td>
                            <td class="py-3.5 px-4 space-y-0.5 text-[11px] max-w-sm">
                                <div><strong class="text-emerald-700">Skor 2:</strong> <span class="text-slate-600"><?= esc($ind['guide_score_2']) ?></span></div>
                                <div><strong class="text-amber-700">Skor 1:</strong> <span class="text-slate-600"><?= esc($ind['guide_score_1']) ?></span></div>
                                <div><strong class="text-rose-700">Skor 0:</strong> <span class="text-slate-600"><?= esc($ind['guide_score_0']) ?></span></div>
                            </td>
                            <td class="py-3.5 px-4">
                                <?php if ($ind['is_active']): ?>
                                    <span class="inline-flex items-center gap-1 text-[11px] text-emerald-600 font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 text-[11px] text-slate-400 font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span> Nonaktif
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-2 whitespace-nowrap">
                                <a href="<?= base_url('/indicators/edit/' . $ind['id']) ?>" 
                                   class="text-xs font-semibold text-slate-700 hover:text-slate-900">
                                    Edit
                                </a>
                                <a href="<?= base_url('/indicators/toggle/' . $ind['id']) ?>" 
                                   class="text-xs font-semibold <?= $ind['is_active'] ? 'text-amber-600 hover:text-amber-700' : 'text-emerald-600 hover:text-emerald-700' ?>">
                                    <?= $ind['is_active'] ? 'Nonaktifkan' : 'Aktifkan' ?>
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
