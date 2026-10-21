<?php

namespace App\Models;

use CodeIgniter\Model;

class EvaluationIndicatorModel extends Model
{
    protected $table            = 'evaluation_indicators';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pillar_id',
        'code',
        'name',
        'guide_score_2',
        'guide_score_1',
        'guide_score_0',
        'order_num',
        'is_active',
    ];

    public function getAllGroupedByPillar()
    {
        $indicators = $this->select('evaluation_indicators.*, evaluation_pillars.name as pillar_name, evaluation_pillars.order_num as pillar_order')
                           ->join('evaluation_pillars', 'evaluation_pillars.id = evaluation_indicators.pillar_id')
                           ->where('evaluation_indicators.is_active', 1)
                           ->orderBy('evaluation_pillars.order_num', 'ASC')
                           ->orderBy('evaluation_indicators.order_num', 'ASC')
                           ->findAll();

        $grouped = [];
        foreach ($indicators as $ind) {
            $grouped[$ind['pillar_name']][] = $ind;
        }
        return $grouped;
    }
}
