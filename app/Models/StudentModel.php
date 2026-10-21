<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table            = 'students';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'class_id',
        'nis',
        'nisn',
        'full_name',
        'nickname',
        'gender',
        'birth_place',
        'birth_date',
        'parent_name',
        'parent_phone',
        'address',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getStudentsWithDetails(?int $classId = null)
    {
        $builder = $this->select('students.*, classes.name as class_name, classes.level as class_level, users.username as account_username')
                        ->join('classes', 'classes.id = students.class_id')
                        ->join('users', 'users.id = students.user_id', 'left');

        if ($classId !== null) {
            $builder->where('students.class_id', $classId);
        }

        return $builder->orderBy('students.full_name', 'ASC')->findAll();
    }
}
