<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6 max-w-3xl mx-auto">
    <!-- Header with Student & Date Picker -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <span class="inline-block px-2.5 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800 uppercase tracking-wider mb-1">
                Jurnal Pembiasaan Harian &bull; Step-by-Step
            </span>
            <h2 class="text-xl font-bold text-slate-800"><?= esc($student['full_name']) ?></h2>
            <p class="text-xs text-slate-500 mt-0.5">NIS: <?= esc($student['nis']) ?> &bull; Panggilan: <?= esc($student['nickname'] ?? '-') ?></p>
        </div>

        <form method="GET" class="flex items-center gap-2">
            <label for="date-input" class="text-xs font-semibold text-slate-600">Tanggal:</label>
            <input type="date" id="date-input" name="date" value="<?= esc($date) ?>" onchange="this.form.submit()"
                   class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
        </form>
    </div>

    <!-- Wizard Stepper (5 Pilar + Konfirmasi) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
        <!-- Progress Bar Line -->
        <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden mb-4">
            <div id="wizard-progress-bar" class="bg-emerald-500 h-full transition-all duration-300 w-1/6"></div>
        </div>

        <!-- Step Badges Horizontal Scrollable on Mobile -->
        <div class="flex items-center justify-between gap-1 overflow-x-auto pb-1 text-xs select-none">
            <?php 
            $stepIndex = 1;
            $pillarKeys = array_keys($pillarsWithIndicators);
            $totalSteps = count($pillarKeys) + 1; // 5 pilar + 1 review
            foreach ($pillarKeys as $pName): 
            ?>
                <button type="button" onclick="goToStep(<?= $stepIndex ?>)" id="step-badge-<?= $stepIndex ?>" 
                        class="step-badge flex items-center gap-1.5 px-3 py-1.5 rounded-xl font-semibold transition whitespace-nowrap text-slate-400 bg-slate-50 hover:bg-slate-100">
                    <span class="step-num w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold bg-slate-200 text-slate-600">
                        <?= $stepIndex ?>
                    </span>
                    <span class="text-xs"><?= esc($pName) ?></span>
                </button>
            <?php 
                $stepIndex++;
            endforeach; 
            ?>
            <!-- Step Review -->
            <button type="button" onclick="goToStep(<?= $totalSteps ?>)" id="step-badge-<?= $totalSteps ?>"
                    class="step-badge flex items-center gap-1.5 px-3 py-1.5 rounded-xl font-semibold transition whitespace-nowrap text-slate-400 bg-slate-50 hover:bg-slate-100">
                <span class="step-num w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold bg-slate-200 text-slate-600">
                    <?= $totalSteps ?>
                </span>
                <span class="text-xs">Selesai</span>
            </button>
        </div>
    </div>

    <!-- Sticky Header Indicator (HANYA GURU/ADMIN YANG MELIHAT ANGKA SKOR & PREDIKAT) -->
    <div class="p-4 bg-slate-900/90 backdrop-blur-md text-white rounded-2xl shadow-lg flex items-center justify-between sticky top-3 z-20">
        <?php if ($role === 'parent'): ?>
            <!-- Tampilan Bersih untuk Orang Tua (Tanpa Skor / Predikat) -->
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center">
                    <i data-lucide="check-square" class="w-4 h-4"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-white">Pendampingan Jurnal Ananda</p>
                    <p class="text-[11px] text-slate-400">Pilih opsi deskripsi yang paling sesuai hari ini</p>
                </div>
            </div>
        <?php else: ?>
            <!-- Tampilan Lengkap Skor untuk Guru / Admin -->
            <div class="flex items-center gap-3 sm:gap-6">
                <div>
                    <p class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Total Skor</p>
                    <p class="text-base sm:text-lg font-bold"><span id="live-total">0</span> <span class="text-xs text-slate-400">/ 36</span></p>
                </div>
                <div class="h-7 w-px bg-slate-700"></div>
                <div>
                    <p class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Rata-Rata</p>
                    <p class="text-base sm:text-lg font-bold"><span id="live-average">0.00</span> <span class="text-xs text-slate-400">/ 2.0</span></p>
                </div>
                <div class="h-7 w-px bg-slate-700"></div>
                <div>
                    <p class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Capaian</p>
                    <span id="live-grade" class="px-2 py-0.5 rounded text-xs font-bold bg-slate-800 text-slate-300">BB</span>
                </div>
            </div>
        <?php endif; ?>

        <div class="text-right">
            <span id="step-label" class="text-xs font-bold text-emerald-400">Langkah 1 dari <?= $totalSteps ?></span>
        </div>
    </div>

    <!-- Main Wizard Form -->
    <form id="daily-wizard-form" action="<?= base_url('/assessment/daily/save') ?>" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="student_id" value="<?= esc($student['id']) ?>">
        <input type="hidden" name="assessment_date" value="<?= esc($date) ?>">

        <!-- STEPS 1 to 5: Pillars -->
        <?php 
        $currentStep = 1;
        $globalIndicatorNum = 1;
        foreach ($pillarsWithIndicators as $pillarName => $indicators): 
        ?>
            <div id="wizard-step-<?= $currentStep ?>" class="wizard-step <?= $currentStep === 1 ? '' : 'hidden' ?> space-y-4">
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="border-b border-slate-100 pb-3 mb-5 flex items-center justify-between">
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-600">Pilar <?= $currentStep ?> dari 5</span>
                            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                <?= esc($pillarName) ?>
                            </h3>
                        </div>
                        <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-medium">
                            <?= count($indicators) ?> Indikator
                        </span>
                    </div>

                    <!-- Indicators in this Pillar -->
                    <div class="space-y-5">
                        <?php foreach ($indicators as $ind): ?>
                            <?php 
                            $selectedScore = $existingScores[$ind['id']] ?? 0;
                            
                            // Bersihkan label opsi dari awalan angka "2: ", "1: ", "0: " jika role parent
                            $label2 = preg_replace('/^2:\s*/i', '', $ind['guide_score_2']);
                            $label1 = preg_replace('/^1:\s*/i', '', $ind['guide_score_1']);
                            $label0 = preg_replace('/^0:\s*/i', '', $ind['guide_score_0']);
                            ?>
                            <div class="p-4 bg-slate-50/80 border border-slate-200 rounded-xl space-y-3">
                                <div class="flex items-start justify-between gap-2">
                                    <h4 class="text-xs font-bold text-slate-800 leading-snug">
                                        <?= $globalIndicatorNum++ ?>. <?= esc($ind['name']) ?>
                                    </h4>
                                </div>

                                <!-- 3 Pilihan Observasi (Deskriptif untuk Ortu, Skor untuk Guru) -->
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 text-xs">
                                    <!-- Opsi Mandiri / Ceria (Score 2) -->
                                    <label class="cursor-pointer relative flex items-start gap-2.5 p-3 rounded-xl border border-slate-200 bg-white hover:border-emerald-500 hover:shadow-sm transition">
                                        <input type="radio" name="scores[<?= $ind['id'] ?>]" value="2" 
                                               class="mt-0.5 text-emerald-600 focus:ring-emerald-500 indicator-radio" 
                                               <?= $selectedScore === 2 ? 'checked' : '' ?> onchange="calculateLiveScore()">
                                        <div>
                                            <?php if ($role !== 'parent'): ?>
                                                <span class="font-bold text-emerald-700 block">Skor 2</span>
                                            <?php endif; ?>
                                            <span class="text-xs font-medium text-slate-700 leading-tight block <?= $role !== 'parent' ? 'mt-0.5' : '' ?>">
                                                <?= esc($label2) ?>
                                            </span>
                                        </div>
                                    </label>

                                    <!-- Opsi Diingatkan / Dibantu (Score 1) -->
                                    <label class="cursor-pointer relative flex items-start gap-2.5 p-3 rounded-xl border border-slate-200 bg-white hover:border-amber-500 hover:shadow-sm transition">
                                        <input type="radio" name="scores[<?= $ind['id'] ?>]" value="1" 
                                               class="mt-0.5 text-amber-600 focus:ring-amber-500 indicator-radio" 
                                               <?= $selectedScore === 1 ? 'checked' : '' ?> onchange="calculateLiveScore()">
                                        <div>
                                            <?php if ($role !== 'parent'): ?>
                                                <span class="font-bold text-amber-700 block">Skor 1</span>
                                            <?php endif; ?>
                                            <span class="text-xs font-medium text-slate-700 leading-tight block <?= $role !== 'parent' ? 'mt-0.5' : '' ?>">
                                                <?= esc($label1) ?>
                                            </span>
                                        </div>
                                    </label>

                                    <!-- Opsi Belum Mau / Butuh Pendampingan (Score 0) -->
                                    <label class="cursor-pointer relative flex items-start gap-2.5 p-3 rounded-xl border border-slate-200 bg-white hover:border-rose-500 hover:shadow-sm transition">
                                        <input type="radio" name="scores[<?= $ind['id'] ?>]" value="0" 
                                               class="mt-0.5 text-rose-600 focus:ring-rose-500 indicator-radio" 
                                               <?= $selectedScore === 0 ? 'checked' : '' ?> onchange="calculateLiveScore()">
                                        <div>
                                            <?php if ($role !== 'parent'): ?>
                                                <span class="font-bold text-rose-700 block">Skor 0</span>
                                            <?php endif; ?>
                                            <span class="text-xs font-medium text-slate-700 leading-tight block <?= $role !== 'parent' ? 'mt-0.5' : '' ?>">
                                                <?= esc($label0) ?>
                                            </span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Navigation Buttons for this step -->
                <div class="flex items-center justify-between pt-2">
                    <?php if ($currentStep > 1): ?>
                        <button type="button" onclick="goToStep(<?= $currentStep - 1 ?>)"
                                class="px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl transition flex items-center gap-1.5">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i>
                            <span>Pilar Sebelumnya</span>
                        </button>
                    <?php else: ?>
                        <div></div>
                    <?php endif; ?>

                    <button type="button" onclick="goToStep(<?= $currentStep + 1 ?>)"
                            class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm shadow-emerald-200 transition flex items-center gap-1.5">
                        <span>Lanjut ke Pilar Berikutnya</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        <?php 
            $currentStep++;
        endforeach; 
        ?>

        <!-- STEP 6: Review & Final Submission -->
        <div id="wizard-step-<?= $totalSteps ?>" class="wizard-step hidden space-y-5">
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-600">Langkah Terakhir</span>
                    <h3 class="text-lg font-bold text-slate-800">
                        <?= $role === 'parent' ? 'Konfirmasi Pengisian Jurnal' : 'Ringkasan & Simpan Penilaian' ?>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">
                        <?= $role === 'parent' ? 'Terima kasih atas pendampingan Ayah/Bunda hari ini. Silakan klik simpan untuk mengirim data jurnal ke guru.' : 'Periksa kembali akumulasi capaian perkembangan sebelum disimpan.' ?>
                    </p>
                </div>

                <?php if ($role === 'parent'): ?>
                    <!-- Tampilan Ramah & Positif untuk Orang Tua (Tanpa Nilai / Tanpa Angka) -->
                    <div class="p-5 bg-emerald-50 border border-emerald-200 rounded-xl space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="heart" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-emerald-900">Seluruh 18 Indikator Karakter Telah Dipilih</h4>
                                <p class="text-xs text-emerald-700 mt-0.5">Tanggal Jurnal: <?= date('d F Y', strtotime($date)) ?></p>
                            </div>
                        </div>
                        <p class="text-xs text-slate-600 pt-2 border-t border-emerald-100 leading-relaxed">
                            Data pembiasaan baik Ananda <strong><?= esc($student['full_name']) ?></strong> akan diteruskan ke wali kelas untuk dipantau dan diberikan evaluasi berkala.
                        </p>
                    </div>
                <?php else: ?>
                    <!-- Ringkasan Nilai Hanya untuk Guru / Admin -->
                    <div class="p-5 bg-gradient-to-br from-slate-50 to-slate-100 border border-slate-200 rounded-xl space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-600">Tanggal Penilaian:</span>
                            <span class="text-xs font-bold text-slate-800"><?= date('d F Y', strtotime($date)) ?></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-600">Total Skor Terkumpul:</span>
                            <span class="text-sm font-bold text-slate-800"><span id="review-total">0</span> / 36</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-600">Rata-Rata Skor Harian:</span>
                            <span class="text-base font-bold text-emerald-700"><span id="review-avg">0.00</span> / 2.00</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-600">Kategori Capaian:</span>
                            <span id="review-grade" class="px-2.5 py-0.5 rounded text-xs font-bold bg-slate-200 text-slate-800">BB</span>
                        </div>
                        <div class="pt-2 border-t border-slate-200 text-xs text-slate-600">
                            <p class="font-bold text-slate-800 mb-0.5">Rekomendasi Treatment Guru:</p>
                            <p id="review-treatment" class="italic text-slate-600">Memerlukan intervensi khusus.</p>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="teacher_note" class="block text-xs font-bold text-slate-800">
                            Catatan Khusus Guru / Wali Kelas (Opsional):
                        </label>
                        <textarea id="teacher_note" name="teacher_note" rows="3"
                                  placeholder="Catatan observasi guru atau apresiasi untuk murid..."
                                  class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20"><?= esc($assessment['teacher_note'] ?? '') ?></textarea>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Action Buttons for Final Step -->
            <div class="flex items-center justify-between pt-2">
                <button type="button" onclick="goToStep(<?= $totalSteps - 1 ?>)"
                        class="px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl transition flex items-center gap-1.5">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    <span>Kembali ke Pilar 5</span>
                </button>

                <button type="submit"
                        class="px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-emerald-200 transition flex items-center gap-2">
                    <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                    <span><?= $role === 'parent' ? 'Simpan Jurnal Pembiasaan' : 'Selesai & Simpan Penilaian' ?></span>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    const totalSteps = <?= $totalSteps ?>;
    let currentStep = 1;

    function goToStep(step) {
        if (step < 1 || step > totalSteps) return;

        // Hide all steps
        document.querySelectorAll('.wizard-step').forEach(el => el.classList.add('hidden'));

        // Show target step
        const target = document.getElementById('wizard-step-' + step);
        if (target) {
            target.classList.remove('hidden');
        }

        currentStep = step;

        // Update progress bar
        const percent = (currentStep / totalSteps) * 100;
        document.getElementById('wizard-progress-bar').style.width = percent + '%';

        // Update step badges
        for (let i = 1; i <= totalSteps; i++) {
            const badge = document.getElementById('step-badge-' + i);
            const num = badge ? badge.querySelector('.step-num') : null;
            if (badge && num) {
                if (i === currentStep) {
                    badge.className = 'step-badge flex items-center gap-1.5 px-3 py-1.5 rounded-xl font-bold transition whitespace-nowrap text-emerald-800 bg-emerald-100 ring-2 ring-emerald-500/30';
                    num.className = 'step-num w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold bg-emerald-600 text-white';
                } else if (i < currentStep) {
                    badge.className = 'step-badge flex items-center gap-1.5 px-3 py-1.5 rounded-xl font-semibold transition whitespace-nowrap text-slate-700 bg-slate-100';
                    num.className = 'step-num w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold bg-slate-300 text-slate-800';
                } else {
                    badge.className = 'step-badge flex items-center gap-1.5 px-3 py-1.5 rounded-xl font-medium transition whitespace-nowrap text-slate-400 bg-slate-50 hover:bg-slate-100';
                    num.className = 'step-num w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold bg-slate-200 text-slate-500';
                }
            }
        }

        // Update step label
        document.getElementById('step-label').innerText = 'Langkah ' + currentStep + ' dari ' + totalSteps;

        // Scroll to top of form smoothly
        window.scrollTo({ top: 120, behavior: 'smooth' });
    }

    function calculateLiveScore() {
        const radios = document.querySelectorAll('.indicator-radio:checked');
        let total = 0;
        let count = 0;

        radios.forEach(r => {
            total += parseInt(r.value, 10);
            count++;
        });

        const avg = count > 0 ? (total / count).toFixed(2) : '0.00';
        
        const liveTotal = document.getElementById('live-total');
        const liveAvg = document.getElementById('live-average');
        if (liveTotal) liveTotal.innerText = total;
        if (liveAvg) liveAvg.innerText = avg;

        const gradeEl = document.getElementById('live-grade');
        let grade = 'BB';
        let gradeClass = 'bg-rose-100 text-rose-800';
        let treatment = 'Memerlukan intervensi khusus. Lakukan konseling/dialog mendalam bersama orang tua dan susun pendampingan terpandu.';

        if (avg >= 1.63) {
            grade = 'BSB';
            gradeClass = 'bg-emerald-100 text-emerald-800';
            treatment = 'Anak sangat mandiri & konsisten. Berikan proyek tantangan kepemimpinan dan pengayaan aktivitas baru.';
        } else if (avg >= 1.26) {
            grade = 'BSH';
            gradeClass = 'bg-blue-100 text-blue-800';
            treatment = 'Anak berkembang sesuai usia. Pertahankan stimulasi rutin harian dan berikan pujian/apresiasi positif.';
        } else if (avg >= 0.76) {
            grade = 'MB';
            gradeClass = 'bg-amber-100 text-amber-800';
            treatment = 'Anak masih butuh bimbingan. Lakukan pendampingan personal (scaffolding) dan tingkatkan komunikasi rumah-sekolah.';
        }

        if (gradeEl) {
            gradeEl.className = 'px-2 py-0.5 rounded text-xs font-bold ' + gradeClass;
            gradeEl.innerText = grade;
        }

        // Review step elements
        const revTotal = document.getElementById('review-total');
        const revAvg = document.getElementById('review-avg');
        const revGrade = document.getElementById('review-grade');
        const revTreatment = document.getElementById('review-treatment');

        if (revTotal) revTotal.innerText = total;
        if (revAvg) revAvg.innerText = avg;
        if (revGrade) {
            revGrade.className = 'px-2.5 py-0.5 rounded text-xs font-bold ' + gradeClass;
            revGrade.innerText = grade;
        }
        if (revTreatment) revTreatment.innerText = treatment;
    }

    document.addEventListener('DOMContentLoaded', () => {
        goToStep(1);
        calculateLiveScore();
    });
</script>
<?= $this->endSection() ?>
