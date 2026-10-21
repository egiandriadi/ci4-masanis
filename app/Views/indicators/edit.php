<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Edit Indikator Instrumen</h2>
            <p class="text-xs text-slate-500">Perbarui bunyi indikator atau deskripsi rubrik penilaian.</p>
        </div>
        <a href="<?= base_url('/indicators') ?>" class="text-xs font-semibold text-slate-600 hover:text-slate-800">
            &larr; Kembali
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
        <form action="<?= base_url('/indicators/update/' . $indicator['id']) ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label for="pillar_id" class="block text-xs font-bold text-slate-700 mb-1">Kategori / Pilar Perkembangan *</label>
                    <select id="pillar_id" name="pillar_id" required
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                        <?php foreach ($pillars as $p): ?>
                            <option value="<?= $p['id'] ?>" <?= $p['id'] == $indicator['pillar_id'] ? 'selected' : '' ?>>
                                Pilar <?= esc($p['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="code" class="block text-xs font-bold text-slate-700 mb-1">Kode Indikator</label>
                    <input type="text" id="code" name="code" value="<?= esc($indicator['code']) ?>"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                </div>
            </div>

            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 mb-1">Nama / Deskripsi Aktivitas Indikator *</label>
                <textarea id="name" name="name" rows="2" required
                          class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20"><?= esc($indicator['name']) ?></textarea>
            </div>

            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-3">
                <h4 class="text-xs font-bold text-slate-800">Panduan Rubrik Skor (0, 1, 2)</h4>

                <div>
                    <label for="guide_score_2" class="block text-[11px] font-bold text-emerald-800 mb-1">Deskripsi Skor 2 (Mandiri / Ceria / Tepat Waktu) *</label>
                    <input type="text" id="guide_score_2" name="guide_score_2" value="<?= esc($indicator['guide_score_2']) ?>" required
                           class="w-full px-3.5 py-2 bg-white border border-slate-200 rounded-lg text-xs text-slate-800 focus:ring-2 focus:ring-emerald-500/20">
                </div>

                <div>
                    <label for="guide_score_1" class="block text-[11px] font-bold text-amber-800 mb-1">Deskripsi Skor 1 (Perlu Diingatkan / Dibantu) *</label>
                    <input type="text" id="guide_score_1" name="guide_score_1" value="<?= esc($indicator['guide_score_1']) ?>" required
                           class="w-full px-3.5 py-2 bg-white border border-slate-200 rounded-lg text-xs text-slate-800 focus:ring-2 focus:ring-emerald-500/20">
                </div>

                <div>
                    <label for="guide_score_0" class="block text-[11px] font-bold text-rose-800 mb-1">Deskripsi Skor 0 (Belum Mau / Perlu Bimbingan) *</label>
                    <input type="text" id="guide_score_0" name="guide_score_0" value="<?= esc($indicator['guide_score_0']) ?>" required
                           class="w-full px-3.5 py-2 bg-white border border-slate-200 rounded-lg text-xs text-slate-800 focus:ring-2 focus:ring-emerald-500/20">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="order_num" class="block text-xs font-bold text-slate-700 mb-1">Nomor Urutan</label>
                    <input type="number" id="order_num" name="order_num" value="<?= esc($indicator['order_num']) ?>"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                </div>
                <div class="flex items-center gap-2 pt-6">
                    <input type="checkbox" id="is_active" name="is_active" value="1" <?= $indicator['is_active'] ? 'checked' : '' ?> class="rounded text-emerald-600 focus:ring-emerald-500">
                    <label for="is_active" class="text-xs text-slate-700 font-medium">Aktif dalam jurnal penilaian</label>
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit"
                        class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-sm shadow-emerald-200 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
