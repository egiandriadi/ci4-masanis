<?php

namespace App\Models;

use CodeIgniter\Model;

class ClassModel extends Model
{
    protected $table            = 'classes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'academic_year_id',
        'name',
        'level',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getClassesWithAcademicYear()
    {
        return $this->select('classes.*, academic_years.name as academic_year_name, academic_years.semester, teachers.full_name as homeroom_teacher_name')
                    ->join('academic_years', 'academic_years.id = classes.academic_year_id')
                    ->join('class_teachers', 'class_teachers.class_id = classes.id AND class_teachers.is_homeroom = 1', 'left')
                    ->join('teachers', 'teachers.id = class_teachers.teacher_id', 'left')
                    ->findAll();
    }
}
