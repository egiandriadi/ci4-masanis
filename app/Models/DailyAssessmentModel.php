<?php

namespace App\Models;

use CodeIgniter\Model;

class DailyAssessmentModel extends Model
{
    protected $table            = 'daily_assessments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'student_id',
        'assessment_date',
        'total_score',
        'average_score',
        'category_grade',
        'filled_by',
        'teacher_note',
        'verified_by_teacher_id',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public static function calculateGrade(float $avgScore): string
    {
        if ($avgScore >= 1.63) {
            return 'BSB';
        }
        if ($avgScore >= 1.26) {
            return 'BSH';
        }
        if ($avgScore >= 0.76) {
            return 'MB';
        }
        return 'BB';
    }

    public static function getTreatmentRecommendation(string $grade): string
    {
        switch ($grade) {
            case 'BSB':
                return 'Anak sangat mandiri & konsisten. Berikan proyek tantangan kepemimpinan dan pengayaan aktivitas baru.';
            case 'BSH':
                return 'Anak berkembang sesuai usia. Pertahankan stimulasi rutin harian dan berikan pujian/apresiasi positif.';
            case 'MB':
                return 'Anak masih butuh bimbingan. Lakukan pendampingan personal (scaffolding) dan tingkatkan komunikasi rumah-sekolah.';
            case 'BB':
            default:
                return 'Memerlukan intervensi khusus. Lakukan konseling/dialog mendalam bersama orang tua dan susun pendampingan terpandu.';
        }
    }
}
