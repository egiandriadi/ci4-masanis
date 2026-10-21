<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\StudentModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function processLogin()
    {
        $identifier = trim($this->request->getPost('identifier') ?? '');
        $password   = $this->request->getPost('password') ?? '';

        if (empty($identifier) || empty($password)) {
            return redirect()->back()->withInput()->with('error', 'Silakan masukkan username / NIS / No. HP dan password.');
        }

        $userModel = new UserModel();
        $user = $userModel->findForAuth($identifier);

        // Jika tidak ketemu langsung di tabel users, cek juga apakah identifier ini adalah parent_phone di tabel students
        if (! $user) {
            $studentModel = new StudentModel();
            $student = $studentModel->where('parent_phone', $identifier)->first();
            if ($student && ! empty($student['user_id'])) {
                $user = $userModel->find($student['user_id']);
            }
        }

        if (! $user) {
            return redirect()->back()->withInput()->with('error', 'Akun tidak ditemukan. Periksa kembali NIS/Username/No HP.');
        }

        if ((int) $user['is_active'] !== 1) {
            return redirect()->back()->with('error', 'Akun Anda sedang dinonaktifkan.');
        }

        if (! password_verify($password, $user['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'Password yang Anda masukkan salah.');
        }

        // Simpan sesi login
        $sessionData = [
            'user_id'      => $user['id'],
            'username'     => $user['username'],
            'name'         => $user['name'],
            'role'         => $user['role'],
            'is_logged_in' => true,
        ];

        // Jika parent, cari siswa terkait
        if ($user['role'] === 'parent') {
            $studentModel = new StudentModel();
            $student = $studentModel->where('user_id', $user['id'])->first();
            if ($student) {
                $sessionData['student_id'] = $student['id'];
                $sessionData['student_name'] = $student['full_name'];
                $sessionData['class_id'] = $student['class_id'];
            }
        } elseif ($user['role'] === 'teacher') {
            $teacherModel = new \App\Models\TeacherModel();
            $teacher = $teacherModel->where('user_id', $user['id'])->first();
            if ($teacher) {
                $sessionData['teacher_id'] = $teacher['id'];
            }
        }

        session()->set($sessionData);

        return redirect()->to('/dashboard')->with('success', 'Selamat datang, ' . $user['name'] . '!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah berhasil keluar.');
    }
}
