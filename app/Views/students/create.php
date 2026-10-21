<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Tambah Siswa Baru</h2>
            <p class="text-xs text-slate-500">Sistem akan otomatis membuat akun login orang tua (Password default: siswa123).</p>
        </div>
        <a href="<?= base_url('/students') ?>" class="text-xs font-semibold text-slate-600 hover:text-slate-800">
            &larr; Kembali
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
        <form action="<?= base_url('/students/store') ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nis" class="block text-xs font-bold text-slate-700 mb-1">NIS (Nomor Induk Siswa) *</label>
                    <input type="text" id="nis" name="nis" value="<?= old('nis') ?>" required
                           placeholder="Contoh: 2026002"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                </div>

                <div>
                    <label for="nisn" class="block text-xs font-bold text-slate-700 mb-1">NISN (Opsional)</label>
                    <input type="text" id="nisn" name="nisn" value="<?= old('nisn') ?>"
                           placeholder="Nomor Induk Siswa Nasional"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="full_name" class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Siswa *</label>
                    <input type="text" id="full_name" name="full_name" value="<?= old('full_name') ?>" required
                           placeholder="Nama lengkap ananda"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                </div>

                <div>
                    <label for="nickname" class="block text-xs font-bold text-slate-700 mb-1">Nama Panggilan</label>
                    <input type="text" id="nickname" name="nickname" value="<?= old('nickname') ?>"
                           placeholder="Nama panggilan harian"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="class_id" class="block text-xs font-bold text-slate-700 mb-1">Rombel / Kelas *</label>
                    <select id="class_id" name="class_id" required
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                        <?php foreach ($classes as $c): ?>
                            <option value="<?= esc($c['id']) ?>"><?= esc($c['name']) ?> (<?= esc($c['level']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="gender" class="block text-xs font-bold text-slate-700 mb-1">Jenis Kelamin *</label>
                    <select id="gender" name="gender" required
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="parent_name" class="block text-xs font-bold text-slate-700 mb-1">Nama Orang Tua / Wali *</label>
                    <input type="text" id="parent_name" name="parent_name" value="<?= old('parent_name') ?>" required
                           placeholder="Nama ayah / ibu"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                </div>

                <div>
                    <label for="parent_phone" class="block text-xs font-bold text-slate-700 mb-1">No. HP Orang Tua (WhatsApp) *</label>
                    <input type="text" id="parent_phone" name="parent_phone" value="<?= old('parent_phone') ?>" required
                           placeholder="0812... (Bisa untuk login)"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                </div>
            </div>

            <div>
                <label for="address" class="block text-xs font-bold text-slate-700 mb-1">Alamat Tempat Tinggal</label>
                <textarea id="address" name="address" rows="2"
                          placeholder="Alamat rumah..."
                          class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20"><?= old('address') ?></textarea>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit"
                        class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-sm shadow-emerald-200 transition">
                    Simpan & Buat Akun Siswa
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
