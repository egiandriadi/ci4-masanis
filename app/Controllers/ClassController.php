<?php

namespace App\Controllers;

use App\Models\ClassModel;
use App\Models\TeacherModel;

class ClassController extends BaseController
{
    public function index()
    {
        $classModel = new ClassModel();
        $classes = $classModel->getClassesWithAcademicYear();

        $data = [
            'title'   => 'Data Kelas',
            'classes' => $classes,
        ];

        return view('classes/index', $data);
    }

    public function create()
    {
        $db = \Config\Database::connect();
        $academicYears = $db->table('academic_years')->get()->getResultArray();
        $teacherModel = new TeacherModel();
        $teachers = $teacherModel->findAll();

        $data = [
            'title'         => 'Tambah Kelas Baru',
            'academicYears' => $academicYears,
            'teachers'      => $teachers,
        ];

        return view('classes/create', $data);
    }

    public function store()
    {
        $rules = [
            'name'             => 'required',
            'level'            => 'required|in_list[KB,TK-A,TK-B]',
            'academic_year_id' => 'required|numeric',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $classModel = new ClassModel();
        $classId = $classModel->insert([
            'academic_year_id' => $this->request->getPost('academic_year_id'),
            'name'             => trim($this->request->getPost('name')),
            'level'            => $this->request->getPost('level'),
        ]);

        $teacherId = $this->request->getPost('teacher_id');
        if ($teacherId) {
            $db = \Config\Database::connect();
            $db->table('class_teachers')->insert([
                'class_id'    => $classId,
                'teacher_id'  => $teacherId,
                'is_homeroom' => 1,
            ]);
        }

        return redirect()->to('/classes')->with('success', 'Kelas baru berhasil ditambahkan.');
    }
}
