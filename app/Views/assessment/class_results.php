<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Header with Filters -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Rekap Penilaian Per Kelas</h2>
            <p class="text-xs text-slate-500">Hasil evaluasi indikator per siswa berdasarkan kelas dan periode bulan.</p>
        </div>

        <form method="GET" class="flex flex-wrap items-center gap-2">
            <!-- Filter Kelas -->
            <select name="class_id" class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white">
                <?php foreach ($classes as $c): ?>
                    <option value="<?= esc($c['id']) ?>" <?= $c['id'] == $selectedClassId ? 'selected' : '' ?>>
                        <?= esc($c['name']) ?> (<?= esc($c['level']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Filter Bulan -->
            <select name="month" class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white">
                <?php
                $months = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ];
                foreach ($months as $mNum => $mName):
                ?>
                    <option value="<?= $mNum ?>" <?= $mNum == $month ? 'selected' : '' ?>><?= $mName ?></option>
                <?php endforeach; ?>
            </select>

            <select name="year" class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white">
                <option value="2026" <?= $year == 2026 ? 'selected' : '' ?>>2026</option>
                <option value="2027" <?= $year == 2027 ? 'selected' : '' ?>>2027</option>
            </select>

            <button type="submit" class="px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl transition">
                Tampilkan
            </button>
        </form>
    </div>

    <!-- Table of Students & Assessment Results -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                <i data-lucide="users" class="w-4 h-4 text-emerald-600"></i>
                Daftar Siswa & Evaluasi Bulan <?= $months[$month] ?? '' ?> <?= esc($year) ?>
            </h3>
            <span class="text-xs text-slate-500 font-medium"><?= count($students) ?> Siswa Terdaftar</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <th class="py-3 px-4 font-semibold">No</th>
                        <th class="py-3 px-4 font-semibold">NIS</th>
                        <th class="py-3 px-4 font-semibold">Nama Siswa</th>
                        <th class="py-3 px-4 font-semibold">Orang Tua / HP</th>
                        <th class="py-3 px-4 font-semibold">Hari Terisi</th>
                        <th class="py-3 px-4 font-semibold">Rata-Rata</th>
                        <th class="py-3 px-4 font-semibold">Predikat</th>
                        <th class="py-3 px-4 font-semibold">Rekomendasi Treatment Guru</th>
                        <th class="py-3 px-4 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($students)): ?>
                        <tr>
                            <td colspan="9" class="py-8 text-center text-slate-400">Belum ada siswa di kelas ini.</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($students as $s): ?>
                            <?php $summary = $studentSummaries[$s['id']] ?? ['filled_days' => 0, 'month_avg' => 0, 'grade' => '-', 'treatment' => 'Belum Ada Data Input']; ?>
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-3 px-4 text-slate-500"><?= $no++ ?></td>
                                <td class="py-3 px-4 font-mono font-medium text-slate-700"><?= esc($s['nis']) ?></td>
                                <td class="py-3 px-4 font-bold text-slate-800"><?= esc($s['full_name']) ?></td>
                                <td class="py-3 px-4 text-slate-600">
                                    <div><?= esc($s['parent_name']) ?></div>
                                    <div class="text-[10px] text-slate-400 font-mono"><?= esc($s['parent_phone']) ?></div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="font-bold text-slate-700"><?= esc($summary['filled_days']) ?></span> / 31 hari
                                </td>
                                <td class="py-3 px-4 font-bold text-slate-800 text-sm">
                                    <?= esc($summary['month_avg']) ?>
                                </td>
                                <td class="py-3 px-4">
                                    <?php if ($summary['grade'] !== '-'): ?>
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold 
                                            <?= $summary['grade'] === 'BSB' ? 'bg-emerald-100 text-emerald-800' : 
                                               ($summary['grade'] === 'BSH' ? 'bg-blue-100 text-blue-800' : 
                                               ($summary['grade'] === 'MB' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800')) ?>">
                                            <?= esc($summary['grade']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-slate-400">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-4 text-slate-600 max-w-xs truncate" title="<?= esc($summary['treatment']) ?>">
                                    <?= esc($summary['treatment']) ?>
                                </td>
                                <td class="py-3 px-4 text-right space-x-1 whitespace-nowrap">
                                    <a href="<?= base_url('/assessment/daily/' . $s['id']) ?>" 
                                       class="px-2.5 py-1 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 rounded-md font-semibold text-[11px] transition">
                                        Input Jurnal
                                    </a>
                                    <a href="<?= base_url('/assessment/student/' . $s['id'] . '/yearly?year=' . $year) ?>" 
                                       class="px-2.5 py-1 bg-slate-100 text-slate-700 hover:bg-slate-200 rounded-md font-semibold text-[11px] transition">
                                        Rekap Raport
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
