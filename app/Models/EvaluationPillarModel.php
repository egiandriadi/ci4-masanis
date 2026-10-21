<?php

namespace App\Models;

use CodeIgniter\Model;

class EvaluationPillarModel extends Model
{
    protected $table            = 'evaluation_pillars';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'order_num',
    ];

    public function getPillarsWithIndicatorCount()
    {
        return $this->select('evaluation_pillars.*, COUNT(evaluation_indicators.id) as total_indicators')
                    ->join('evaluation_indicators', 'evaluation_indicators.pillar_id = evaluation_pillars.id', 'left')
                    ->groupBy('evaluation_pillars.id')
                    ->orderBy('evaluation_pillars.order_num', 'ASC')
                    ->findAll();
    }
}
