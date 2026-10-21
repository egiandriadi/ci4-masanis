<?php

namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\ClassModel;
use App\Models\TeacherModel;
use App\Models\DailyAssessmentModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $role = session()->get('role');
        $data = [
            'title' => 'Dashboard',
            'role'  => $role,
        ];

        if ($role === 'admin') {
            $studentModel = new StudentModel();
            $teacherModel = new TeacherModel();
            $classModel   = new ClassModel();
            $assessModel  = new DailyAssessmentModel();

            $data['totalStudents']    = $studentModel->countAllResults();
            $data['totalTeachers']    = $teacherModel->countAllResults();
            $data['totalClasses']     = $classModel->countAllResults();
            $data['todayAssessments'] = $assessModel->where('assessment_date', date('Y-m-d'))->countAllResults();

            return view('dashboard/admin', $data);
        }

        if ($role === 'teacher') {
            $teacherId = session()->get('teacher_id');
            $db = \Config\Database::connect();
            
            // Get teacher classes
            $classes = $db->table('class_teachers')
                          ->select('classes.*')
                          ->join('classes', 'classes.id = class_teachers.class_id')
                          ->where('class_teachers.teacher_id', $teacherId)
                          ->get()->getResultArray();

            $classIds = array_column($classes, 'id');

            $studentModel = new StudentModel();
            $totalStudents = !empty($classIds) ? $studentModel->whereIn('class_id', $classIds)->countAllResults() : 0;

            $assessModel = new DailyAssessmentModel();
            $todayFilled = 0;
            if (!empty($classIds)) {
                $todayFilled = $assessModel->select('daily_assessments.id')
                                           ->join('students', 'students.id = daily_assessments.student_id')
                                           ->whereIn('students.class_id', $classIds)
                                           ->where('daily_assessments.assessment_date', date('Y-m-d'))
                                           ->countAllResults();
            }

            $data['classes']       = $classes;
            $data['totalStudents'] = $totalStudents;
            $data['todayFilled']   = $todayFilled;

            return view('dashboard/teacher', $data);
        }

        if ($role === 'parent') {
            $studentId = session()->get('student_id');
            $studentModel = new StudentModel();
            $student = $studentModel->find($studentId);

            $assessModel = new DailyAssessmentModel();
            $todayAssessment = $assessModel->where('student_id', $studentId)
                                           ->where('assessment_date', date('Y-m-d'))
                                           ->first();

            // Recent 7 days assessments
            $recentAssessments = $assessModel->where('student_id', $studentId)
                                             ->orderBy('assessment_date', 'DESC')
                                             ->findAll(7);

            $data['student']           = $student;
            $data['todayAssessment']   = $todayAssessment;
            $data['recentAssessments'] = $recentAssessments;

            return view('dashboard/parent', $data);
        }

        return redirect()->to('/login');
    }
}
