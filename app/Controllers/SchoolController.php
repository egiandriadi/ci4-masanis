<?php

namespace App\Controllers;

use App\Models\SchoolProfileModel;

class SchoolController extends BaseController
{
    public function profile()
    {
        $schoolModel = new SchoolProfileModel();
        $profile = $schoolModel->first();

        $data = [
            'title'   => 'Identitas Sekolah',
            'profile' => $profile,
        ];

        return view('school/profile', $data);
    }

    public function updateProfile()
    {
        $schoolModel = new SchoolProfileModel();
        $profile = $schoolModel->first();

        $saveData = [
            'school_name'    => trim($this->request->getPost('school_name')),
            'npsn'           => trim($this->request->getPost('npsn')),
            'principal_name' => trim($this->request->getPost('principal_name')),
            'phone'          => trim($this->request->getPost('phone')),
            'email'          => trim($this->request->getPost('email')),
            'address'        => trim($this->request->getPost('address')),
        ];

        if ($profile) {
            $schoolModel->update($profile['id'], $saveData);
        } else {
            $schoolModel->insert($saveData);
        }

        return redirect()->to('/school/profile')->with('success', 'Identitas sekolah berhasil diperbarui.');
    }
}
