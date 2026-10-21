<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TeacherModel;
use App\Models\StudentModel;

class UserController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $users = $userModel->orderBy('id', 'DESC')->findAll();

        $data = [
            'title' => 'Manajemen Pengguna',
            'users' => $users,
        ];

        return view('users/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Pengguna Baru',
        ];

        return view('users/create', $data);
    }

    public function store()
    {
        $rules = [
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'password' => 'required|min_length[6]',
            'role'     => 'required|in_list[admin,teacher,parent]',
            'name'     => 'required|min_length[2]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $userModel->insert([
            'username'      => trim($this->request->getPost('username')),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role'          => $this->request->getPost('role'),
            'name'          => trim($this->request->getPost('name')),
            'phone'         => trim($this->request->getPost('phone')),
            'email'         => trim($this->request->getPost('email')),
            'is_active'     => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to('/users')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function toggleStatus(int $id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if ($user) {
            $newStatus = ($user['is_active'] == 1) ? 0 : 1;
            $userModel->update($id, ['is_active' => $newStatus]);
        }

        return redirect()->to('/users')->with('success', 'Status pengguna berhasil diperbarui.');
    }
}
