<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | Jurnal Penilaian TK Mas Anis</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="inline-flex w-14 h-14 rounded-2xl bg-emerald-600 text-white items-center justify-center font-bold text-2xl shadow-lg shadow-emerald-200 mb-3">
                TK
            </div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">TK Mas Anis</h1>
            <p class="text-sm text-slate-500 mt-1">Sistem Jurnal Penilaian Perkembangan Anak</p>
        </div>

        <!-- Card Shadcn style -->
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-8">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-slate-800">Selamat Datang</h2>
                <p class="text-xs text-slate-500 mt-0.5">Masuk menggunakan Akun Admin, Guru, atau NIS / No. HP Orang Tua</p>
            </div>

            <!-- Flash Alert -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="mb-5 flex items-center gap-2.5 p-3.5 bg-rose-50 border border-rose-200 rounded-xl text-rose-800 text-xs font-medium">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600 flex-shrink-0"></i>
                    <span><?= esc(session()->getFlashdata('error')) ?></span>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="mb-5 flex items-center gap-2.5 p-3.5 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-xs font-medium">
                    <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 flex-shrink-0"></i>
                    <span><?= esc(session()->getFlashdata('success')) ?></span>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('/login') ?>" method="POST" class="space-y-4">
                <?= csrf_field() ?>

                <div>
                    <label for="identifier" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Username / NIS / No. HP Orang Tua
                    </label>
                    <div class="relative">
                        <i data-lucide="user" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                        <input type="text" id="identifier" name="identifier" value="<?= old('identifier') ?>" required
                               placeholder="Contoh: admin / guru1 / 2026001 / 0812..."
                               class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Password
                    </label>
                    <div class="relative">
                        <i data-lucide="lock" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                        <input type="password" id="password" name="password" required
                               placeholder="••••••••"
                               class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition">
                    </div>
                </div>

                <button type="submit"
                        class="w-full mt-2 py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-xl shadow-sm shadow-emerald-200 transition duration-150 flex items-center justify-center gap-2">
                    <span>Masuk ke Sistem</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </form>

            <!-- Quick Demo Credentials Box -->
            <div class="mt-6 pt-5 border-t border-slate-100 text-[11px] text-slate-500 space-y-1 bg-slate-50 p-3 rounded-xl border border-slate-100">
                <p class="font-semibold text-slate-700">Akun Demo Default:</p>
                <div class="flex justify-between">
                    <span>Admin: <strong class="text-slate-700 font-mono">admin</strong></span>
                    <span>Pass: <strong class="text-slate-700 font-mono">admin123</strong></span>
                </div>
                <div class="flex justify-between">
                    <span>Guru: <strong class="text-slate-700 font-mono">guru1</strong></span>
                    <span>Pass: <strong class="text-slate-700 font-mono">guru123</strong></span>
                </div>
                <div class="flex justify-between">
                    <span>Siswa: <strong class="text-slate-700 font-mono">2026001</strong></span>
                    <span>Pass: <strong class="text-slate-700 font-mono">siswa123</strong></span>
                </div>
            </div>
        </div>

        <p class="text-center text-xs text-slate-400 mt-6">
            &copy; 2026 TK Islam Terpadu Mas Anis &bull; All Rights Reserved
        </p>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
