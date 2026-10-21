<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Tambah Kelas Baru</h2>
            <p class="text-xs text-slate-500">Tentukan nama kelompok belajar dan tunjuk wali kelas.</p>
        </div>
        <a href="<?= base_url('/classes') ?>" class="text-xs font-semibold text-slate-600 hover:text-slate-800">
            &larr; Kembali
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
        <form action="<?= base_url('/classes/store') ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>

            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 mb-1">Nama Rombongan Belajar (Kelas) *</label>
                <input type="text" id="name" name="name" value="<?= old('name') ?>" required
                       placeholder="Contoh: TK-A Khadijah / TK-B Aisyah"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="level" class="block text-xs font-bold text-slate-700 mb-1">Jenjang / Kelompok *</label>
                    <select id="level" name="level" required
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                        <option value="TK-A">TK-A (Usia 4 - 5 Tahun)</option>
                        <option value="TK-B">TK-B (Usia 5 - 6 Tahun)</option>
                        <option value="KB">Kelompok Bermain (KB)</option>
                    </select>
                </div>

                <div>
                    <label for="academic_year_id" class="block text-xs font-bold text-slate-700 mb-1">Tahun Ajaran *</label>
                    <select id="academic_year_id" name="academic_year_id" required
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                        <?php foreach ($academicYears as $ay): ?>
                            <option value="<?= esc($ay['id']) ?>"><?= esc($ay['name']) ?> (Semester <?= esc($ay['semester']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div>
                <label for="teacher_id" class="block text-xs font-bold text-slate-700 mb-1">Tunjuk Wali Kelas</label>
                <select id="teacher_id" name="teacher_id"
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                    <option value="">-- Pilih Guru Wali Kelas --</option>
                    <?php foreach ($teachers as $t): ?>
                        <option value="<?= esc($t['id']) ?>"><?= esc($t['full_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit"
                        class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-sm shadow-emerald-200 transition">
                    Simpan Data Kelas
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
