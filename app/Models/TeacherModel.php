<?php

namespace App\Models;

use CodeIgniter\Model;

class TeacherModel extends Model
{
    protected $table            = 'teachers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'nip',
        'full_name',
        'gender',
        'phone',
        'address',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getTeachersWithUser()
    {
        return $this->select('teachers.*, users.username, users.email, users.is_active')
                    ->join('users', 'users.id = teachers.user_id')
                    ->findAll();
    }
}
