<?php

namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\ClassModel;
use App\Models\UserModel;

class StudentController extends BaseController
{
    public function index()
    {
        $classId = $this->request->getGet('class_id') ? (int) $this->request->getGet('class_id') : null;
        $studentModel = new StudentModel();
        $students = $studentModel->getStudentsWithDetails($classId);

        $classModel = new ClassModel();
        $classes = $classModel->findAll();

        $data = [
            'title'           => 'Data Siswa',
            'students'        => $students,
            'classes'         => $classes,
            'selectedClassId' => $classId,
        ];

        return view('students/index', $data);
    }

    public function create()
    {
        $classModel = new ClassModel();
        $classes = $classModel->findAll();

        $data = [
            'title'   => 'Tambah Siswa Baru',
            'classes' => $classes,
        ];

        return view('students/create', $data);
    }

    public function store()
    {
        $rules = [
            'full_name'    => 'required|min_length[3]',
            'nis'          => 'required|is_unique[students.nis]',
            'class_id'     => 'required|numeric',
            'gender'       => 'required|in_list[L,P]',
            'parent_name'  => 'required',
            'parent_phone' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $userModel = new UserModel();
        // Otomatis buat akun orang tua login menggunakan NIS atau no HP, password default siswa123
        $defaultPassword = password_hash('siswa123', PASSWORD_BCRYPT);
        $userModel->insert([
            'username'      => trim($this->request->getPost('nis')),
            'password_hash' => $defaultPassword,
            'role'          => 'parent',
            'name'          => trim($this->request->getPost('full_name')) . ' (Ortu: ' . trim($this->request->getPost('parent_name')) . ')',
            'phone'         => trim($this->request->getPost('parent_phone')),
            'is_active'     => 1,
        ]);
        $userId = $db->insertID();

        $studentModel = new StudentModel();
        $studentModel->insert([
            'user_id'      => $userId,
            'class_id'     => $this->request->getPost('class_id'),
            'nis'          => trim($this->request->getPost('nis')),
            'nisn'         => trim($this->request->getPost('nisn')),
            'full_name'    => trim($this->request->getPost('full_name')),
            'nickname'     => trim($this->request->getPost('nickname')),
            'gender'       => $this->request->getPost('gender'),
            'birth_place'  => trim($this->request->getPost('birth_place')),
            'birth_date'   => $this->request->getPost('birth_date') ?: null,
            'parent_name'  => trim($this->request->getPost('parent_name')),
            'parent_phone' => trim($this->request->getPost('parent_phone')),
            'address'      => trim($this->request->getPost('address')),
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data siswa.');
        }

        return redirect()->to('/students')->with('success', 'Siswa dan akun orang tua berhasil ditambahkan! Password login default: siswa123');
    }
}
