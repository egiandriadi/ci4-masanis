<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Sistem Penilaian Anak TK') ?> | TK Islam Terpadu Mas Anis</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased min-h-screen flex">

    <!-- Sidebar (Shadcn style) -->
    <aside class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col flex-shrink-0">
        <!-- Brand -->
        <div class="h-16 flex items-center gap-3 px-6 border-b border-slate-100">
            <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-lg shadow-sm shadow-emerald-200">
                TK
            </div>
            <div>
                <h1 class="text-sm font-bold text-slate-800 leading-tight">Jurnal Perkembangan</h1>
                <p class="text-[11px] text-slate-500 font-medium">TK Mas Anis</p>
            </div>
        </div>

        <!-- Navigation Links -->
        <div class="flex-1 px-4 py-5 space-y-1 overflow-y-auto">
            <div class="px-3 pb-2 text-[11px] font-semibold tracking-wider text-slate-400 uppercase">Menu Utama</div>

            <a href="<?= base_url('/dashboard') ?>" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg <?= uri_string() === 'dashboard' ? 'bg-slate-100 text-slate-900 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?> transition">
                <i data-lucide="layout-dashboard" class="w-4 h-4 text-slate-500"></i>
                Dashboard
            </a>

            <?php if (session()->get('role') === 'parent'): ?>
                <a href="<?= base_url('/assessment/daily') ?>" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg <?= str_contains(uri_string(), 'assessment/daily') ? 'bg-slate-100 text-slate-900 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?> transition">
                    <i data-lucide="check-square" class="w-4 h-4 text-emerald-600"></i>
                    Isi Jurnal Harian
                </a>
            <?php endif; ?>

            <?php if (in_array(session()->get('role'), ['teacher', 'admin'])): ?>
                <div class="pt-4 px-3 pb-2 text-[11px] font-semibold tracking-wider text-slate-400 uppercase">Evaluasi & Instrumen</div>
                <a href="<?= base_url('/assessment/class-results') ?>" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg <?= str_contains(uri_string(), 'assessment/class-results') ? 'bg-slate-100 text-slate-900 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?> transition">
                    <i data-lucide="clipboard-list" class="w-4 h-4 text-emerald-600"></i>
                    Rekap Hasil Per Kelas
                </a>
                <a href="<?= base_url('/students') ?>" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg <?= uri_string() === 'students' ? 'bg-slate-100 text-slate-900 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?> transition">
                    <i data-lucide="users" class="w-4 h-4 text-slate-500"></i>
                    Daftar Siswa
                </a>
            <?php endif; ?>

            <?php if (session()->get('role') === 'admin'): ?>
                <div class="pt-4 px-3 pb-2 text-[11px] font-semibold tracking-wider text-slate-400 uppercase">Master Data</div>
                <a href="<?= base_url('/teachers') ?>" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg <?= uri_string() === 'teachers' ? 'bg-slate-100 text-slate-900 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?> transition">
                    <i data-lucide="graduation-cap" class="w-4 h-4 text-slate-500"></i>
                    Daftar Guru
                </a>
                <a href="<?= base_url('/classes') ?>" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg <?= uri_string() === 'classes' ? 'bg-slate-100 text-slate-900 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?> transition">
                    <i data-lucide="school" class="w-4 h-4 text-slate-500"></i>
                    Daftar Kelas
                </a>
                <a href="<?= base_url('/users') ?>" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg <?= uri_string() === 'users' ? 'bg-slate-100 text-slate-900 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?> transition">
                    <i data-lucide="user-cog" class="w-4 h-4 text-slate-500"></i>
                    Manajemen Pengguna
                </a>
                <a href="<?= base_url('/school/profile') ?>" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg <?= uri_string() === 'school/profile' ? 'bg-slate-100 text-slate-900 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?> transition">
                    <i data-lucide="building-2" class="w-4 h-4 text-slate-500"></i>
                    Identitas Sekolah
                </a>

                <div class="pt-4 px-3 pb-2 text-[11px] font-semibold tracking-wider text-slate-400 uppercase">Setup Instrumen</div>
                <a href="<?= base_url('/pillars') ?>" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg <?= uri_string() === 'pillars' ? 'bg-slate-100 text-slate-900 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?> transition">
                    <i data-lucide="layers" class="w-4 h-4 text-slate-500"></i>
                    Kategori (Pilar)
                </a>
                <a href="<?= base_url('/indicators') ?>" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg <?= str_contains(uri_string(), 'indicators') ? 'bg-slate-100 text-slate-900 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?> transition">
                    <i data-lucide="list-checks" class="w-4 h-4 text-emerald-600"></i>
                    Indikator & Rubrik
                </a>
            <?php endif; ?>
        </div>

        <!-- User Profile Card -->
        <div class="p-4 border-t border-slate-100">
            <div class="flex items-center gap-3 p-2 bg-slate-50 rounded-lg">
                <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center font-bold text-slate-600 text-xs">
                    <?= strtoupper(substr(session()->get('name') ?? 'U', 0, 1)) ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-slate-800 truncate"><?= esc(session()->get('name')) ?></p>
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-emerald-100 text-emerald-800 uppercase">
                        <?= esc(session()->get('role')) ?>
                    </span>
                </div>
                <a href="<?= base_url('/logout') ?>" title="Keluar" class="text-slate-400 hover:text-rose-600 transition p-1">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
        <!-- Topbar Mobile -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 md:px-8">
            <div class="flex items-center gap-2">
                <span class="text-xs font-medium px-2 py-1 bg-slate-100 text-slate-600 rounded-md">T.A 2026/2027</span>
                <span class="text-sm font-semibold text-slate-700 hidden sm:inline"><?= esc($title ?? 'Dashboard') ?></span>
            </div>
            <div class="flex items-center gap-3">
                <a href="<?= base_url('/logout') ?>" class="text-xs font-medium text-slate-600 hover:text-rose-600 flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 transition">
                    <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                    <span>Keluar</span>
                </a>
            </div>
        </header>

        <!-- Flash Messages -->
        <div class="px-4 md:px-8 pt-6 max-w-7xl w-full mx-auto">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="mb-4 flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-sm shadow-sm">
                    <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600 flex-shrink-0"></i>
                    <p><?= esc(session()->getFlashdata('success')) ?></p>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="mb-4 flex items-center gap-3 p-4 bg-rose-50 border border-rose-200 rounded-xl text-rose-800 text-sm shadow-sm">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-rose-600 flex-shrink-0"></i>
                    <p><?= esc(session()->getFlashdata('error')) ?></p>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="mb-4 p-4 bg-rose-50 border border-rose-200 rounded-xl text-rose-800 text-sm shadow-sm">
                    <div class="font-semibold mb-1">Terjadi kesalahan input:</div>
                    <ul class="list-disc list-inside space-y-0.5 text-xs">
                        <?php foreach (session()->getFlashdata('errors') as $err): ?>
                            <li><?= esc($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

        <!-- Main View Injection -->
        <main class="flex-1 px-4 md:px-8 pb-12 max-w-7xl w-full mx-auto">
            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
