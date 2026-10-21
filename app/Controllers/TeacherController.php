<?php

namespace App\Controllers;

use App\Models\TeacherModel;
use App\Models\UserModel;

class TeacherController extends BaseController
{
    public function index()
    {
        $teacherModel = new TeacherModel();
        $teachers = $teacherModel->getTeachersWithUser();

        $data = [
            'title'    => 'Data Guru',
            'teachers' => $teachers,
        ];

        return view('teachers/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Guru Baru',
        ];

        return view('teachers/create', $data);
    }

    public function store()
    {
        $rules = [
            'full_name' => 'required|min_length[3]',
            'username'  => 'required|min_length[3]|is_unique[users.username]',
            'password'  => 'required|min_length[6]',
            'gender'    => 'required|in_list[L,P]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $userModel = new UserModel();
        $userModel->insert([
            'username'      => trim($this->request->getPost('username')),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role'          => 'teacher',
            'name'          => trim($this->request->getPost('full_name')),
            'phone'         => trim($this->request->getPost('phone')),
            'email'         => trim($this->request->getPost('email')),
            'is_active'     => 1,
        ]);
        $userId = $db->insertID();

        $teacherModel = new TeacherModel();
        $teacherModel->insert([
            'user_id'   => $userId,
            'nip'       => trim($this->request->getPost('nip')),
            'full_name' => trim($this->request->getPost('full_name')),
            'gender'    => $this->request->getPost('gender'),
            'phone'     => trim($this->request->getPost('phone')),
            'address'   => trim($this->request->getPost('address')),
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan guru.');
        }

        return redirect()->to('/teachers')->with('success', 'Guru baru dan akun login berhasil dibuat.');
    }
}
