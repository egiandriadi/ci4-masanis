<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInitialSchema extends Migration
{
    public function up()
    {
        // 1. School Profiles
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'school_name'    => ['type' => 'VARCHAR', 'constraint' => 150],
            'npsn'           => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'address'        => ['type' => 'TEXT', 'null' => true],
            'phone'          => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'email'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'principal_name' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'logo'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('school_profiles', true);

        // 2. Academic Years
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'       => ['type' => 'VARCHAR', 'constraint' => 50], // 2026/2027
            'semester'   => ['type' => 'ENUM', 'constraint' => ['1', '2'], 'default' => '1'],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('academic_years', true);

        // 3. Users (admin, teacher, parent)
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'username'      => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
            'password_hash' => ['type' => 'VARCHAR', 'constraint' => 255],
            'role'          => ['type' => 'ENUM', 'constraint' => ['admin', 'teacher', 'parent']],
            'name'          => ['type' => 'VARCHAR', 'constraint' => 150],
            'phone'         => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'email'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'is_active'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('users', true);

        // 4. Classes
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'academic_year_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'name'             => ['type' => 'VARCHAR', 'constraint' => 50],
            'level'            => ['type' => 'ENUM', 'constraint' => ['KB', 'TK-A', 'TK-B'], 'default' => 'TK-A'],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('academic_year_id', 'academic_years', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('classes', true);

        // 5. Teachers
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'unique' => true],
            'nip'        => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'full_name'  => ['type' => 'VARCHAR', 'constraint' => 150],
            'gender'     => ['type' => 'ENUM', 'constraint' => ['L', 'P'], 'default' => 'P'],
            'phone'      => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'address'    => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('teachers', true);

        // 6. Class Teachers (Homeroom / Teachers)
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'class_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'teacher_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'is_homeroom' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('class_id', 'classes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('teacher_id', 'teachers', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('class_teachers', true);

        // 7. Students
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true, 'unique' => true],
            'class_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nis'          => ['type' => 'VARCHAR', 'constraint' => 30, 'unique' => true],
            'nisn'         => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'full_name'    => ['type' => 'VARCHAR', 'constraint' => 150],
            'nickname'     => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'gender'       => ['type' => 'ENUM', 'constraint' => ['L', 'P']],
            'birth_place'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'birth_date'   => ['type' => 'DATE', 'null' => true],
            'parent_name'  => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'parent_phone' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'address'      => ['type' => 'TEXT', 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('class_id', 'classes', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('students', true);

        // 8. Evaluation Pillars
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'order_num' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('evaluation_pillars', true);

        // 9. Evaluation Indicators (18 indicators from Excel)
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'pillar_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'code'          => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'name'          => ['type' => 'TEXT'],
            'guide_score_2' => ['type' => 'TEXT'],
            'guide_score_1' => ['type' => 'TEXT'],
            'guide_score_0' => ['type' => 'TEXT'],
            'order_num'     => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'is_active'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('pillar_id', 'evaluation_pillars', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('evaluation_indicators', true);

        // 10. Daily Assessments (Header)
        $this->forge->addField([
            'id'                     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'student_id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'assessment_date'        => ['type' => 'DATE'],
            'total_score'            => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'average_score'          => ['type' => 'DECIMAL', 'constraint' => '4,2', 'default' => '0.00'],
            'category_grade'         => ['type' => 'ENUM', 'constraint' => ['BSB', 'BSH', 'MB', 'BB'], 'null' => true],
            'filled_by'              => ['type' => 'ENUM', 'constraint' => ['parent', 'teacher'], 'default' => 'parent'],
            'teacher_note'           => ['type' => 'TEXT', 'null' => true],
            'verified_by_teacher_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at'             => ['type' => 'DATETIME', 'null' => true],
            'updated_at'             => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey(['student_id', 'assessment_date']);
        $this->forge->addForeignKey('student_id', 'students', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('verified_by_teacher_id', 'teachers', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('daily_assessments', true);

        // 11. Daily Assessment Items (Detail 18 items per day)
        $this->forge->addField([
            'id'                  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'daily_assessment_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'indicator_id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'score'               => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'note'                => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('daily_assessment_id', 'daily_assessments', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('indicator_id', 'evaluation_indicators', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('daily_assessment_items', true);

        // 12. Monthly Reports (Summary cache)
        $this->forge->addField([
            'id'                       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'student_id'               => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'year'                     => ['type' => 'INT', 'constraint' => 4],
            'month'                    => ['type' => 'TINYINT', 'constraint' => 2],
            'average_score'            => ['type' => 'DECIMAL', 'constraint' => '4,2', 'default' => '0.00'],
            'category_grade'           => ['type' => 'ENUM', 'constraint' => ['BSB', 'BSH', 'MB', 'BB']],
            'recommendation_treatment' => ['type' => 'TEXT'],
            'teacher_feedback'         => ['type' => 'TEXT', 'null' => true],
            'created_at'               => ['type' => 'DATETIME', 'null' => true],
            'updated_at'               => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey(['student_id', 'year', 'month']);
        $this->forge->addForeignKey('student_id', 'students', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('monthly_reports', true);
    }

    public function down()
    {
        $this->forge->dropTable('monthly_reports', true);
        $this->forge->dropTable('daily_assessment_items', true);
        $this->forge->dropTable('daily_assessments', true);
        $this->forge->dropTable('evaluation_indicators', true);
        $this->forge->dropTable('evaluation_pillars', true);
        $this->forge->dropTable('students', true);
        $this->forge->dropTable('class_teachers', true);
        $this->forge->dropTable('teachers', true);
        $this->forge->dropTable('classes', true);
        $this->forge->dropTable('users', true);
        $this->forge->dropTable('academic_years', true);
        $this->forge->dropTable('school_profiles', true);
    }
}
