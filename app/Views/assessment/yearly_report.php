<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Header with Student Profile Info (Seperti Header Excel) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <span class="inline-block px-2.5 py-0.5 rounded text-[11px] font-semibold bg-emerald-100 text-emerald-800 uppercase mb-1">
                Rekapitulasi Evaluasi 1 Tahun Ajaran
            </span>
            <h2 class="text-xl font-bold text-slate-800"><?= esc($student['full_name']) ?></h2>
            <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-500 mt-1">
                <span><strong>NIS:</strong> <?= esc($student['nis']) ?></span>
                <span><strong>Kelas:</strong> <?= esc($student['class_name']) ?> (<?= esc($student['level']) ?>)</span>
                <span><strong>Tahun Ajaran:</strong> <?= esc($year) ?>/<?= esc($year + 1) ?></span>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl flex items-center gap-1.5 transition">
                <i data-lucide="printer" class="w-4 h-4"></i>
                <span>Cetak / PDF</span>
            </button>
            <a href="<?= base_url('/assessment/class-results') ?>" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl transition">
                Kembali ke Rekap Kelas
            </a>
        </div>
    </div>

    <!-- Tabel Rekap 12 Bulan (Persis Struktur Excel REKAP_TAHUNAN) -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="text-sm font-bold text-slate-800">
                Tabel Evaluasi Bulanan (Januari - Desember <?= esc($year) ?>)
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <th class="py-3 px-5 font-semibold">Bulan</th>
                        <th class="py-3 px-5 font-semibold">Hari Terisi</th>
                        <th class="py-3 px-5 font-semibold">Rata-Rata Skor (0 - 2.0)</th>
                        <th class="py-3 px-5 font-semibold">Kategori Capaian</th>
                        <th class="py-3 px-5 font-semibold">Status Perkembangan</th>
                        <th class="py-3 px-5 font-semibold">Rekomendasi Treatment Utama Guru</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($rekapBulan as $mNum => $b): ?>
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-5 font-bold text-slate-800"><?= esc($b['name']) ?></td>
                            <td class="py-3.5 px-5 text-slate-500"><?= esc($b['filled_days']) ?> hari</td>
                            <td class="py-3.5 px-5 font-bold text-slate-800">
                                <?= $b['score'] !== null ? esc($b['score']) : '<span class="text-slate-400 font-normal">-</span>' ?>
                            </td>
                            <td class="py-3.5 px-5">
                                <?php if ($b['grade']): ?>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold 
                                        <?= $b['grade'] === 'BSB' ? 'bg-emerald-100 text-emerald-800' : 
                                           ($b['grade'] === 'BSH' ? 'bg-blue-100 text-blue-800' : 
                                           ($b['grade'] === 'MB' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800')) ?>">
                                        <?= esc($b['grade']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-slate-400">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3.5 px-5 text-slate-600 font-medium">
                                <?= esc($b['status'] ?? '-') ?>
                            </td>
                            <td class="py-3.5 px-5 text-slate-600">
                                <?= esc($b['treatment']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="bg-slate-50/80 font-bold border-t-2 border-slate-200">
                    <tr>
                        <td class="py-4 px-5 text-slate-900 uppercase">RATA-RATA TAHUNAN</td>
                        <td class="py-4 px-5 text-slate-600">-</td>
                        <td class="py-4 px-5 text-base text-emerald-700"><?= esc($yearFinalAvg) ?></td>
                        <td class="py-4 px-5">
                            <?php if ($yearFinalGrade !== '-'): ?>
                                <span class="px-2.5 py-1 rounded text-xs font-bold 
                                    <?= $yearFinalGrade === 'BSB' ? 'bg-emerald-100 text-emerald-800' : 
                                       ($yearFinalGrade === 'BSH' ? 'bg-blue-100 text-blue-800' : 
                                       ($yearFinalGrade === 'MB' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800')) ?>">
                                    <?= esc($yearFinalGrade) ?>
                                </span>
                            <?php else: ?>
                                <span class="text-slate-400">-</span>
                            <?php endif; ?>
                        </td>
                        <td colspan="2" class="py-4 px-5 text-slate-600 font-normal">
                            Hasil akumulasi pembiasaan anak selama 1 tahun ajaran.
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Rubrik Penilaian & Panduan Treatment (Sesuai Row 20-25 Excel) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-3">
        <h3 class="text-sm font-bold text-slate-800">
            Rubrik Penilaian & Panduan Klasifikasi Treatment Guru
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
            <div class="p-3.5 rounded-xl border border-emerald-200 bg-emerald-50/50">
                <span class="font-bold text-emerald-800 block text-sm">BSB (1.63 - 2.00) &bull; Berkembang Sangat Baik</span>
                <p class="text-slate-600 mt-1 leading-relaxed">
                    <strong>Treatment Guru & Orang Tua:</strong> Anak sangat mandiri & konsisten. Berikan proyek tantangan kepemimpinan dan pengayaan aktivitas baru.
                </p>
            </div>
            <div class="p-3.5 rounded-xl border border-blue-200 bg-blue-50/50">
                <span class="font-bold text-blue-800 block text-sm">BSH (1.26 - 1.62) &bull; Berkembang Sesuai Harapan</span>
                <p class="text-slate-600 mt-1 leading-relaxed">
                    <strong>Treatment Guru & Orang Tua:</strong> Anak berkembang sesuai usia. Pertahankan stimulasi rutin harian dan berikan pujian/apresiasi positif.
                </p>
            </div>
            <div class="p-3.5 rounded-xl border border-amber-200 bg-amber-50/50">
                <span class="font-bold text-amber-800 block text-sm">MB (0.76 - 1.25) &bull; Mulai Berkembang</span>
                <p class="text-slate-600 mt-1 leading-relaxed">
                    <strong>Treatment Guru & Orang Tua:</strong> Anak masih butuh bimbingan. Lakukan pendampingan personal (scaffolding) dan tingkatkan komunikasi rumah-sekolah.
                </p>
            </div>
            <div class="p-3.5 rounded-xl border border-rose-200 bg-rose-50/50">
                <span class="font-bold text-rose-800 block text-sm">BB (0.00 - 0.75) &bull; Belum Berkembang</span>
                <p class="text-slate-600 mt-1 leading-relaxed">
                    <strong>Treatment Guru & Orang Tua:</strong> Memerlukan intervensi khusus. Lakukan konseling/dialog mendalam bersama orang tua dan susun pendampingan terpandu.
                </p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
