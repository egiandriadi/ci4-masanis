<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Tambah Pengguna Baru</h2>
            <p class="text-xs text-slate-500">Buat akun untuk admin, guru, atau orang tua.</p>
        </div>
        <a href="<?= base_url('/users') ?>" class="text-xs font-semibold text-slate-600 hover:text-slate-800">
            &larr; Kembali
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
        <form action="<?= base_url('/users/store') ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>

            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap *</label>
                <input type="text" id="name" name="name" value="<?= old('name') ?>" required
                       placeholder="Contoh: Ustadzah Nurul"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="username" class="block text-xs font-bold text-slate-700 mb-1">Username / NIS *</label>
                    <input type="text" id="username" name="username" value="<?= old('username') ?>" required
                           placeholder="username unik"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 mb-1">Password *</label>
                    <input type="password" id="password" name="password" required
                           placeholder="Minimal 6 karakter"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="role" class="block text-xs font-bold text-slate-700 mb-1">Peran Pengguna *</label>
                    <select id="role" name="role" required
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                        <option value="teacher">Guru / Tenaga Pendidik</option>
                        <option value="admin">Administrator Sekolah</option>
                        <option value="parent">Orang Tua Siswa</option>
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
                <label for="email" class="block text-xs font-bold text-slate-700 mb-1">Email</label>
                <input type="email" id="email" name="email" value="<?= old('email') ?>"
                       placeholder="email@example.com"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
            </div>

            <div class="flex items-center gap-2 pt-2">
                <input type="checkbox" id="is_active" name="is_active" value="1" checked
                       class="rounded text-emerald-600 focus:ring-emerald-500">
                <label for="is_active" class="text-xs text-slate-700 font-medium">Akun langsung aktif</label>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit"
                        class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-sm shadow-emerald-200 transition">
                    Simpan Pengguna
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
