<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Tambah Guru Baru</h2>
            <p class="text-xs text-slate-500">Buat data profil tenaga pendidik dan akun loginnya.</p>
        </div>
        <a href="<?= base_url('/teachers') ?>" class="text-xs font-semibold text-slate-600 hover:text-slate-800">
            &larr; Kembali
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
        <form action="<?= base_url('/teachers/store') ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="full_name" class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap & Gelar *</label>
                    <input type="text" id="full_name" name="full_name" value="<?= old('full_name') ?>" required
                           placeholder="Contoh: Ustadzah Maryam, S.Pd"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                </div>

                <div>
                    <label for="nip" class="block text-xs font-bold text-slate-700 mb-1">NIP (Opsional)</label>
                    <input type="text" id="nip" name="nip" value="<?= old('nip') ?>"
                           placeholder="Nomor Induk Pegawai"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="username" class="block text-xs font-bold text-slate-700 mb-1">Username Login *</label>
                    <input type="text" id="username" name="username" value="<?= old('username') ?>" required
                           placeholder="guru_maryam"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 mb-1">Password Login *</label>
                    <input type="password" id="password" name="password" required
                           placeholder="Minimal 6 karakter"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="gender" class="block text-xs font-bold text-slate-700 mb-1">Jenis Kelamin *</label>
                    <select id="gender" name="gender" required
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                        <option value="P">Perempuan</option>
                        <option value="L">Laki-laki</option>
                    </select>
                </div>

                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 mb-1">No. HP / WhatsApp</label>
                    <input type="text" id="phone" name="phone" value="<?= old('phone') ?>"
                           placeholder="0812..."
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                </div>
            </div>

            <div>
                <label for="address" class="block text-xs font-bold text-slate-700 mb-1">Alamat</label>
                <textarea id="address" name="address" rows="2"
                          placeholder="Alamat tempat tinggal..."
                          class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20"><?= old('address') ?></textarea>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit"
                        class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-sm shadow-emerald-200 transition">
                    Simpan Data Guru
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
