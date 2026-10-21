<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Student Header Banner -->
    <div class="p-6 bg-gradient-to-r from-emerald-600 to-teal-700 rounded-3xl text-white shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <span class="inline-block px-2.5 py-1 bg-white/20 backdrop-blur-sm rounded-lg text-xs font-semibold uppercase tracking-wider mb-2">
                Jurnal Pembiasaan Karakter Anak
            </span>
            <h2 class="text-2xl font-bold"><?= esc($student['full_name'] ?? 'Ananda') ?></h2>
            <p class="text-xs text-emerald-100 mt-1">NIS: <?= esc($student['nis'] ?? '-') ?> &bull; Nama Panggilan: <?= esc($student['nickname'] ?? '-') ?></p>
        </div>
        <div>
            <a href="<?= base_url('/assessment/daily') ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-emerald-700 hover:bg-emerald-50 text-xs font-bold rounded-xl shadow-md transition">
                <i data-lucide="edit-3" class="w-4 h-4"></i>
                <span>Isi Jurnal Hari Ini</span>
            </a>
        </div>
    </div>

    <!-- Status Jurnal Hari Ini -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
        <h3 class="text-sm font-bold text-slate-800 mb-3 flex items-center gap-2">
            <i data-lucide="calendar" class="w-4 h-4 text-emerald-600"></i>
            Status Jurnal Hari Ini (<?= date('d M Y') ?>)
        </h3>

        <?php if ($todayAssessment): ?>
            <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-emerald-900">Alhamdulillah, Jurnal Hari Ini Sudah Terisi</h4>
                        <p class="text-xs text-emerald-700 mt-0.5">
                            Pengisian selesai &bull; Terima kasih Ayah/Bunda telah mendampingi pembiasaan baik Ananda hari ini.
                        </p>
                    </div>
                </div>
                <a href="<?= base_url('/assessment/daily?date=' . date('Y-m-d')) ?>" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg transition whitespace-nowrap">
                    Lihat / Perbarui Jurnal
                </a>
            </div>
        <?php else: ?>
            <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="clock" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-amber-900">Jurnal Hari Ini Belum Diisi</h4>
                        <p class="text-xs text-amber-700 mt-0.5">
                            Yuk dampingi ananda dan catat pembiasaan baik serta ibadah hari ini.
                        </p>
                    </div>
                </div>
                <a href="<?= base_url('/assessment/daily') ?>" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold rounded-lg transition whitespace-nowrap">
                    Mulai Isi Jurnal Sekarang
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Riwayat Pengisian (Tanpa Skor Angka / Predikat) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                <i data-lucide="history" class="w-4 h-4 text-slate-500"></i>
                Riwayat Pengisian Jurnal Terakhir
            </h3>
        </div>

        <?php if (!empty($recentAssessments)): ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 uppercase text-[10px] tracking-wider">
                            <th class="py-2.5 font-semibold">Tanggal</th>
                            <th class="py-2.5 font-semibold">Status Pengisian</th>
                            <th class="py-2.5 font-semibold">Diisi Oleh</th>
                            <th class="py-2.5 text-right font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php foreach ($recentAssessments as $ra): ?>
                            <tr>
                                <td class="py-3 font-medium text-slate-700"><?= date('d F Y', strtotime($ra['assessment_date'])) ?></td>
                                <td class="py-3">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                        <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-600"></i>
                                        Selesai Diisi
                                    </span>
                                </td>
                                <td class="py-3 text-slate-600">
                                    <?= esc($ra['filled_by'] === 'parent' ? 'Orang Tua' : 'Guru Kelas') ?>
                                </td>
                                <td class="py-3 text-right">
                                    <a href="<?= base_url('/assessment/daily?date=' . $ra['assessment_date']) ?>" class="text-emerald-600 hover:underline font-semibold">
                                        Lihat / Ubah
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-xs text-slate-400 py-4 text-center">Belum ada riwayat pengisian jurnal.</p>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
