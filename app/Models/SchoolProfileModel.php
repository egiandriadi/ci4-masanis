<?php

namespace App\Models;

use CodeIgniter\Model;

class SchoolProfileModel extends Model
{
    protected $table            = 'school_profiles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'school_name',
        'npsn',
        'address',
        'phone',
        'email',
        'principal_name',
        'logo',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
