<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Setup Kategori (Pilar Perkembangan)</h2>
            <p class="text-xs text-slate-500">Kelola 5 pilar utama atau tambahkan kelompok aspek penilaian baru.</p>
        </div>
        <button onclick="document.getElementById('modal-add-pillar').classList.remove('hidden')" 
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl shadow-sm shadow-emerald-200 transition">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Kategori Pilar</span>
        </button>
    </div>

    <!-- Pillars Table -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <th class="py-3 px-5 font-semibold">Urutan</th>
                        <th class="py-3 px-5 font-semibold">Nama Pilar / Kategori</th>
                        <th class="py-3 px-5 font-semibold">Jumlah Indikator Terkait</th>
                        <th class="py-3 px-5 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($pillars as $p): ?>
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-5 font-mono font-bold text-slate-700">#<?= esc($p['order_num']) ?></td>
                            <td class="py-3.5 px-5 font-bold text-slate-800 flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                                <?= esc($p['name']) ?>
                            </td>
                            <td class="py-3.5 px-5 text-slate-600">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 font-semibold text-slate-700 text-[11px]">
                                    <?= esc($p['total_indicators']) ?> Indikator
                                </span>
                            </td>
                            <td class="py-3.5 px-5 text-right space-x-2">
                                <a href="<?= base_url('/indicators?pillar_id=' . $p['id']) ?>" 
                                   class="text-xs font-semibold text-emerald-600 hover:underline">
                                    Lihat Indikator
                                </a>
                                <button type="button" 
                                        onclick="openEditModal(<?= $p['id'] ?>, '<?= esc($p['name'], 'js') ?>', <?= $p['order_num'] ?>)"
                                        class="text-xs font-semibold text-slate-600 hover:text-slate-800">
                                    Edit
                                </button>
                                <?php if ($p['total_indicators'] == 0): ?>
                                    <a href="<?= base_url('/pillars/delete/' . $p['id']) ?>" 
                                       onclick="return confirm('Yakin ingin menghapus kategori ini?')"
                                       class="text-xs font-semibold text-rose-600 hover:underline">
                                        Hapus
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Pilar -->
<div id="modal-add-pillar" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-xl border border-slate-200">
        <h3 class="text-base font-bold text-slate-800 mb-1">Tambah Kategori Pilar Baru</h3>
        <p class="text-xs text-slate-500 mb-4">Pilar digunakan untuk mengelompokkan indikator aktivitas harian.</p>

        <form action="<?= base_url('/pillars/store') ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 mb-1">Nama Pilar / Kategori *</label>
                <input type="text" id="name" name="name" required placeholder="Contoh: Bahasa & Komunikasi"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
            </div>
            <div>
                <label for="order_num" class="block text-xs font-bold text-slate-700 mb-1">Nomor Urutan Tampil *</label>
                <input type="number" id="order_num" name="order_num" value="6" required
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('modal-add-pillar').classList.add('hidden')"
                        class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold hover:bg-slate-200 transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition">
                    Simpan Pilar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Pilar -->
<div id="modal-edit-pillar" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-xl border border-slate-200">
        <h3 class="text-base font-bold text-slate-800 mb-1">Edit Kategori Pilar</h3>
        <p class="text-xs text-slate-500 mb-4">Ubah nama atau urutan pilar perkembangan.</p>

        <form id="form-edit-pillar" action="" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            <div>
                <label for="edit_name" class="block text-xs font-bold text-slate-700 mb-1">Nama Pilar / Kategori *</label>
                <input type="text" id="edit_name" name="name" required
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
            </div>
            <div>
                <label for="edit_order_num" class="block text-xs font-bold text-slate-700 mb-1">Nomor Urutan Tampil *</label>
                <input type="number" id="edit_order_num" name="order_num" required
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('modal-edit-pillar').classList.add('hidden')"
                        class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold hover:bg-slate-200 transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, name, orderNum) {
        document.getElementById('form-edit-pillar').action = '<?= base_url('/pillars/update/') ?>' + id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_order_num').value = orderNum;
        document.getElementById('modal-edit-pillar').classList.remove('hidden');
    }
</script>
<?= $this->endSection() ?>
