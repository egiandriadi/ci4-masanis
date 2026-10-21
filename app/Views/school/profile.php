<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="max-w-2xl mx-auto space-y-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Identitas Sekolah</h2>
        <p class="text-xs text-slate-500">Informasi profil lembaga TK yang akan tercantum pada kop laporan/raport.</p>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
        <form action="<?= base_url('/school/profile/update') ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="school_name" class="block text-xs font-bold text-slate-700 mb-1">Nama Satuan PAUD / TK *</label>
                    <input type="text" id="school_name" name="school_name" value="<?= esc($profile['school_name'] ?? '') ?>" required
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                </div>

                <div>
                    <label for="npsn" class="block text-xs font-bold text-slate-700 mb-1">NPSN</label>
                    <input type="text" id="npsn" name="npsn" value="<?= esc($profile['npsn'] ?? '') ?>"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                </div>
            </div>

            <div>
                <label for="principal_name" class="block text-xs font-bold text-slate-700 mb-1">Nama Kepala Sekolah</label>
                <input type="text" id="principal_name" name="principal_name" value="<?= esc($profile['principal_name'] ?? '') ?>"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 mb-1">No. Telepon / WhatsApp Sekolah</label>
                    <input type="text" id="phone" name="phone" value="<?= esc($profile['phone'] ?? '') ?>"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 mb-1">Email Resmi Sekolah</label>
                    <input type="email" id="email" name="email" value="<?= esc($profile['email'] ?? '') ?>"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                </div>
            </div>

            <div>
                <label for="address" class="block text-xs font-bold text-slate-700 mb-1">Alamat Lengkap Lembaga</label>
                <textarea id="address" name="address" rows="3"
                          class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20"><?= esc($profile['address'] ?? '') ?></textarea>
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
