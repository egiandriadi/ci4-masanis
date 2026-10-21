<?php

namespace App\Controllers;

use App\Models\EvaluationIndicatorModel;
use App\Models\EvaluationPillarModel;

class IndicatorController extends BaseController
{
    public function index()
    {
        $pillarId = $this->request->getGet('pillar_id') ? (int) $this->request->getGet('pillar_id') : null;
        
        $indicatorModel = new EvaluationIndicatorModel();
        $builder = $indicatorModel->select('evaluation_indicators.*, evaluation_pillars.name as pillar_name')
                                 ->join('evaluation_pillars', 'evaluation_pillars.id = evaluation_indicators.pillar_id');

        if ($pillarId) {
            $builder->where('evaluation_indicators.pillar_id', $pillarId);
        }

        $indicators = $builder->orderBy('evaluation_pillars.order_num', 'ASC')
                              ->orderBy('evaluation_indicators.order_num', 'ASC')
                              ->findAll();

        $pillarModel = new EvaluationPillarModel();
        $pillars = $pillarModel->orderBy('order_num', 'ASC')->findAll();

        $data = [
            'title'            => 'Setup Instrumen Indikator',
            'indicators'       => $indicators,
            'pillars'          => $pillars,
            'selectedPillarId' => $pillarId,
        ];

        return view('indicators/index', $data);
    }

    public function create()
    {
        $pillarModel = new EvaluationPillarModel();
        $pillars = $pillarModel->orderBy('order_num', 'ASC')->findAll();

        $data = [
            'title'   => 'Tambah Indikator Baru',
            'pillars' => $pillars,
        ];

        return view('indicators/create', $data);
    }

    public function store()
    {
        $rules = [
            'pillar_id'     => 'required|numeric',
            'name'          => 'required',
            'guide_score_2' => 'required',
            'guide_score_1' => 'required',
            'guide_score_0' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $indicatorModel = new EvaluationIndicatorModel();
        $indicatorModel->insert([
            'pillar_id'     => $this->request->getPost('pillar_id'),
            'code'          => trim($this->request->getPost('code') ?? ''),
            'name'          => trim($this->request->getPost('name')),
            'guide_score_2' => trim($this->request->getPost('guide_score_2')),
            'guide_score_1' => trim($this->request->getPost('guide_score_1')),
            'guide_score_0' => trim($this->request->getPost('guide_score_0')),
            'order_num'     => (int) ($this->request->getPost('order_num') ?? 0),
            'is_active'     => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to('/indicators')->with('success', 'Indikator baru berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $indicatorModel = new EvaluationIndicatorModel();
        $indicator = $indicatorModel->find($id);

        if (! $indicator) {
            return redirect()->to('/indicators')->with('error', 'Indikator tidak ditemukan.');
        }

        $pillarModel = new EvaluationPillarModel();
        $pillars = $pillarModel->orderBy('order_num', 'ASC')->findAll();

        $data = [
            'title'     => 'Edit Instrumen Indikator',
            'indicator' => $indicator,
            'pillars'   => $pillars,
        ];

        return view('indicators/edit', $data);
    }

    public function update(int $id)
    {
        $rules = [
            'pillar_id'     => 'required|numeric',
            'name'          => 'required',
            'guide_score_2' => 'required',
            'guide_score_1' => 'required',
            'guide_score_0' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $indicatorModel = new EvaluationIndicatorModel();
        $indicatorModel->update($id, [
            'pillar_id'     => $this->request->getPost('pillar_id'),
            'code'          => trim($this->request->getPost('code') ?? ''),
            'name'          => trim($this->request->getPost('name')),
            'guide_score_2' => trim($this->request->getPost('guide_score_2')),
            'guide_score_1' => trim($this->request->getPost('guide_score_1')),
            'guide_score_0' => trim($this->request->getPost('guide_score_0')),
            'order_num'     => (int) ($this->request->getPost('order_num') ?? 0),
            'is_active'     => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to('/indicators')->with('success', 'Instrumen indikator berhasil diperbarui.');
    }

    public function toggle(int $id)
    {
        $indicatorModel = new EvaluationIndicatorModel();
        $ind = $indicatorModel->find($id);

        if ($ind) {
            $newStatus = ($ind['is_active'] == 1) ? 0 : 1;
            $indicatorModel->update($id, ['is_active' => $newStatus]);
        }

        return redirect()->to('/indicators')->with('success', 'Status indikator diperbarui.');
    }

    public function delete(int $id)
    {
        $indicatorModel = new EvaluationIndicatorModel();
        $ind = $indicatorModel->find($id);

        if ($ind) {
            $indicatorModel->delete($id);
            return redirect()->to('/indicators')->with('success', 'Indikator berhasil dihapus.');
        }

        return redirect()->to('/indicators')->with('error', 'Indikator tidak ditemukan.');
    }
}
