<?php

namespace App\Controllers;

use App\Models\EvaluationPillarModel;

class PillarController extends BaseController
{
    public function index()
    {
        $pillarModel = new EvaluationPillarModel();
        $pillars = $pillarModel->getPillarsWithIndicatorCount();

        $data = [
            'title'   => 'Setup Kategori (Pilar Evaluasi)',
            'pillars' => $pillars,
        ];

        return view('pillars/index', $data);
    }

    public function store()
    {
        $name = trim($this->request->getPost('name') ?? '');
        $orderNum = (int) ($this->request->getPost('order_num') ?? 0);

        if (empty($name)) {
            return redirect()->back()->with('error', 'Nama pilar / kategori tidak boleh kosong.');
        }

        $pillarModel = new EvaluationPillarModel();
        $pillarModel->insert([
            'name'      => $name,
            'order_num' => $orderNum,
        ]);

        return redirect()->to('/pillars')->with('success', 'Kategori / Pilar berhasil ditambahkan.');
    }

    public function update(int $id)
    {
        $name = trim($this->request->getPost('name') ?? '');
        $orderNum = (int) ($this->request->getPost('order_num') ?? 0);

        if (empty($name)) {
            return redirect()->back()->with('error', 'Nama pilar / kategori tidak boleh kosong.');
        }

        $pillarModel = new EvaluationPillarModel();
        $pillarModel->update($id, [
            'name'      => $name,
            'order_num' => $orderNum,
        ]);

        return redirect()->to('/pillars')->with('success', 'Kategori / Pilar berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $pillarModel = new EvaluationPillarModel();
        $pillar = $pillarModel->find($id);

        if ($pillar) {
            $pillarModel->delete($id);
            return redirect()->to('/pillars')->with('success', 'Kategori berhasil dihapus.');
        }

        return redirect()->to('/pillars')->with('error', 'Kategori tidak ditemukan.');
    }
}
