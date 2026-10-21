<?php

namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\ClassModel;
use App\Models\TeacherModel;
use App\Models\EvaluationIndicatorModel;
use App\Models\DailyAssessmentModel;
use App\Models\DailyAssessmentItemModel;

class AssessmentController extends BaseController
{
    /**
     * Parent/Teacher input daily assessment
     */
    public function dailyInput(?int $studentId = null)
    {
        $role = session()->get('role');

        if ($role === 'parent') {
            $studentId = session()->get('student_id');
        }

        if (! $studentId) {
            return redirect()->to('/dashboard')->with('error', 'Pilih siswa terlebih dahulu.');
        }

        $studentModel = new StudentModel();
        $student = $studentModel->find($studentId);

        if (! $student) {
            return redirect()->to('/dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }

        $date = $this->request->getGet('date') ?? date('Y-m-d');

        $indicatorModel = new EvaluationIndicatorModel();
        $pillarsWithIndicators = $indicatorModel->getAllGroupedByPillar();

        // Check if already filled for this date
        $assessmentModel = new DailyAssessmentModel();
        $assessment = $assessmentModel->where('student_id', $studentId)
                                      ->where('assessment_date', $date)
                                      ->first();

        $existingScores = [];
        if ($assessment) {
            $itemModel = new DailyAssessmentItemModel();
            $items = $itemModel->where('daily_assessment_id', $assessment['id'])->findAll();
            foreach ($items as $it) {
                $existingScores[$it['indicator_id']] = (int) $it['score'];
            }
        }

        $data = [
            'title'                 => 'Jurnal Penilaian Harian',
            'student'               => $student,
            'date'                  => $date,
            'pillarsWithIndicators' => $pillarsWithIndicators,
            'assessment'            => $assessment,
            'existingScores'        => $existingScores,
            'role'                  => $role,
        ];

        return view('assessment/daily_form', $data);
    }

    /**
     * Save daily assessment
     */
    public function saveDaily()
    {
        $role = session()->get('role');
        $studentId = (int) $this->request->getPost('student_id');
        $date      = $this->request->getPost('assessment_date') ?? date('Y-m-d');
        $scores    = $this->request->getPost('scores') ?? []; // [indicator_id => score]

        if ($role === 'parent') {
            $studentId = (int) session()->get('student_id');
        }

        if (empty($studentId)) {
            return redirect()->back()->with('error', 'Siswa tidak valid.');
        }

        $indicatorModel = new EvaluationIndicatorModel();
        $allIndicators = $indicatorModel->where('is_active', 1)->findAll();
        $totalIndicators = count($allIndicators);

        $totalScore = 0;
        $scoredCount = 0;

        foreach ($allIndicators as $ind) {
            $indId = $ind['id'];
            if (isset($scores[$indId])) {
                $val = (int) $scores[$indId];
                if ($val >= 0 && $val <= 2) {
                    $totalScore += $val;
                    $scoredCount++;
                }
            }
        }

        $avgScore = $scoredCount > 0 ? round($totalScore / $scoredCount, 2) : 0.00;
        $categoryGrade = DailyAssessmentModel::calculateGrade($avgScore);

        $assessmentModel = new DailyAssessmentModel();
        $existing = $assessmentModel->where('student_id', $studentId)
                                    ->where('assessment_date', $date)
                                    ->first();

        $filledBy = ($role === 'teacher') ? 'teacher' : 'parent';
        $verifiedBy = ($role === 'teacher') ? session()->get('teacher_id') : null;

        $db = \Config\Database::connect();
        $db->transStart();

        $headerData = [
            'student_id'             => $studentId,
            'assessment_date'        => $date,
            'total_score'            => $totalScore,
            'average_score'          => $avgScore,
            'category_grade'         => $categoryGrade,
            'filled_by'              => $filledBy,
            'verified_by_teacher_id' => $verifiedBy,
        ];

        if ($role === 'teacher' && $this->request->getPost('teacher_note')) {
            $headerData['teacher_note'] = $this->request->getPost('teacher_note');
        }

        if ($existing) {
            $assessmentId = $existing['id'];
            $assessmentModel->update($assessmentId, $headerData);
            // Delete old items
            $db->table('daily_assessment_items')->where('daily_assessment_id', $assessmentId)->delete();
        } else {
            $assessmentId = $assessmentModel->insert($headerData);
        }

        // Insert items
        $itemModel = new DailyAssessmentItemModel();
        foreach ($allIndicators as $ind) {
            $indId = $ind['id'];
            $scoreVal = isset($scores[$indId]) ? (int) $scores[$indId] : 0;
            $itemModel->insert([
                'daily_assessment_id' => $assessmentId,
                'indicator_id'        => $indId,
                'score'               => $scoreVal,
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan penilaian.');
        }

        return redirect()->to('/assessment/daily/' . $studentId . '?date=' . $date)
                         ->with('success', "Penilaian harian berhasil disimpan! Kategori capaian: {$categoryGrade} (Rata-rata: {$avgScore})");
    }

    /**
     * Teacher & Admin view results per class per student
     */
    public function classResults()
    {
        $classId = $this->request->getGet('class_id');
        $month   = (int) ($this->request->getGet('month') ?? date('n'));
        $year    = (int) ($this->request->getGet('year') ?? date('Y'));

        $classModel = new ClassModel();
        $classes = $classModel->findAll();

        if (empty($classId) && !empty($classes)) {
            $classId = $classes[0]['id'];
        }

        $studentModel = new StudentModel();
        $students = $classId ? $studentModel->where('class_id', $classId)->orderBy('full_name', 'ASC')->findAll() : [];

        // Fetch monthly summary for each student in this class
        $assessmentModel = new DailyAssessmentModel();
        $studentSummaries = [];

        foreach ($students as $s) {
            $records = $assessmentModel->where('student_id', $s['id'])
                                       ->where("assessment_date >= '{$year}-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-01'")
                                       ->where("assessment_date <= '{$year}-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-31'")
                                       ->findAll();

            $totalFilledDays = count($records);
            $sumAvg = 0;
            foreach ($records as $r) {
                $sumAvg += (float) $r['average_score'];
            }
            $monthAvg = $totalFilledDays > 0 ? round($sumAvg / $totalFilledDays, 2) : 0;
            $grade = $totalFilledDays > 0 ? DailyAssessmentModel::calculateGrade($monthAvg) : '-';

            $studentSummaries[$s['id']] = [
                'filled_days' => $totalFilledDays,
                'month_avg'   => $monthAvg,
                'grade'       => $grade,
                'treatment'   => $grade !== '-' ? DailyAssessmentModel::getTreatmentRecommendation($grade) : 'Belum Ada Data Input',
            ];
        }

        $data = [
            'title'            => 'Rekap Penilaian Kelas',
            'classes'          => $classes,
            'selectedClassId'  => $classId,
            'month'            => $month,
            'year'             => $year,
            'students'         => $students,
            'studentSummaries' => $studentSummaries,
        ];

        return view('assessment/class_results', $data);
    }

    /**
     * Detailed Rekap Bulanan & Tahunan (Persis seperti format Excel)
     */
    public function studentYearlyReport(int $studentId)
    {
        $studentModel = new StudentModel();
        $student = $studentModel->select('students.*, classes.name as class_name, classes.level')
                                ->join('classes', 'classes.id = students.class_id')
                                ->find($studentId);

        if (! $student) {
            return redirect()->to('/dashboard')->with('error', 'Siswa tidak ditemukan.');
        }

        $year = (int) ($this->request->getGet('year') ?? date('Y'));
        $assessmentModel = new DailyAssessmentModel();

        $monthNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $rekapBulan = [];
        $totalYearAvg = 0;
        $filledMonthCount = 0;

        foreach ($monthNames as $mNum => $mName) {
            $monthStr = str_pad($mNum, 2, '0', STR_PAD_LEFT);
            $records = $assessmentModel->where('student_id', $studentId)
                                       ->where("assessment_date >= '{$year}-{$monthStr}-01'")
                                       ->where("assessment_date <= '{$year}-{$monthStr}-31'")
                                       ->findAll();

            $cnt = count($records);
            if ($cnt > 0) {
                $sum = array_sum(array_column($records, 'average_score'));
                $avg = round($sum / $cnt, 2);
                $grade = DailyAssessmentModel::calculateGrade($avg);
                $treatment = DailyAssessmentModel::getTreatmentRecommendation($grade);
                $statusDesc = ($grade === 'BSB') ? 'Berkembang Sangat Baik' : (($grade === 'BSH') ? 'Berkembang Sesuai Usia' : (($grade === 'MB') ? 'Mulai Berkembang' : 'Perlu Intervensi Khusus'));

                $rekapBulan[$mNum] = [
                    'name'        => $mName,
                    'score'       => $avg,
                    'grade'       => $grade,
                    'status'      => $statusDesc,
                    'treatment'   => $treatment,
                    'filled_days' => $cnt,
                ];
                $totalYearAvg += $avg;
                $filledMonthCount++;
            } else {
                $rekapBulan[$mNum] = [
                    'name'        => $mName,
                    'score'       => null,
                    'grade'       => null,
                    'status'      => null,
                    'treatment'   => 'Belum Ada Data Input',
                    'filled_days' => 0,
                ];
            }
        }

        $yearFinalAvg = $filledMonthCount > 0 ? round($totalYearAvg / $filledMonthCount, 2) : 0;
        $yearFinalGrade = $filledMonthCount > 0 ? DailyAssessmentModel::calculateGrade($yearFinalAvg) : '-';

        $data = [
            'title'          => 'Rekap Tahunan Evaluasi Anak',
            'student'        => $student,
            'year'           => $year,
            'rekapBulan'     => $rekapBulan,
            'yearFinalAvg'   => $yearFinalAvg,
            'yearFinalGrade' => $yearFinalGrade,
        ];

        return view('assessment/yearly_report', $data);
    }
}
