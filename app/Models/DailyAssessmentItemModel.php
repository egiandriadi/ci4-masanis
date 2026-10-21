<?php

namespace App\Models;

use CodeIgniter\Model;

class DailyAssessmentItemModel extends Model
{
    protected $table            = 'daily_assessment_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'daily_assessment_id',
        'indicator_id',
        'score',
        'note',
    ];
}
