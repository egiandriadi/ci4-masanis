<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Landing & Auth
$routes->get('/', 'AuthController::login');
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::processLogin');
$routes->get('/logout', 'AuthController::logout');

// Protected Routes (All Logged In Users)
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/dashboard', 'DashboardController::index');

    // Daily Assessment Routes (Parent & Teacher)
    $routes->get('/assessment/daily', 'AssessmentController::dailyInput');
    $routes->get('/assessment/daily/(:num)', 'AssessmentController::dailyInput/$1');
    $routes->post('/assessment/daily/save', 'AssessmentController::saveDaily');
});

// Teacher & Admin Routes
$routes->group('', ['filter' => 'auth:teacher,admin'], static function ($routes) {
    $routes->get('/assessment/student/(:num)/yearly', 'AssessmentController::studentYearlyReport/$1');
    $routes->get('/assessment/class-results', 'AssessmentController::classResults');
});

// Admin-only Routes
$routes->group('', ['filter' => 'auth:admin'], static function ($routes) {
    // School Profile
    $routes->get('/school/profile', 'SchoolController::profile');
    $routes->post('/school/profile/update', 'SchoolController::updateProfile');

    // Users Management
    $routes->get('/users', 'UserController::index');
    $routes->get('/users/create', 'UserController::create');
    $routes->post('/users/store', 'UserController::store');
    $routes->get('/users/toggle/(:num)', 'UserController::toggleStatus/$1');

    // Teachers Management
    $routes->get('/teachers', 'TeacherController::index');
    $routes->get('/teachers/create', 'TeacherController::create');
    $routes->post('/teachers/store', 'TeacherController::store');

    // Classes Management
    $routes->get('/classes', 'ClassController::index');
    $routes->get('/classes/create', 'ClassController::create');
    $routes->post('/classes/store', 'ClassController::store');

    // Students Management
    $routes->get('/students', 'StudentController::index');
    $routes->get('/students/create', 'StudentController::create');
    $routes->post('/students/store', 'StudentController::store');

    // Instrument Pillars Setup (Kategori)
    $routes->get('/pillars', 'PillarController::index');
    $routes->post('/pillars/store', 'PillarController::store');
    $routes->post('/pillars/update/(:num)', 'PillarController::update/$1');
    $routes->get('/pillars/delete/(:num)', 'PillarController::delete/$1');

    // Instrument Indicators Setup (Indikator & Rubrik)
    $routes->get('/indicators', 'IndicatorController::index');
    $routes->get('/indicators/create', 'IndicatorController::create');
    $routes->post('/indicators/store', 'IndicatorController::store');
    $routes->get('/indicators/edit/(:num)', 'IndicatorController::edit/$1');
    $routes->post('/indicators/update/(:num)', 'IndicatorController::update/$1');
    $routes->get('/indicators/toggle/(:num)', 'IndicatorController::toggle/$1');
    $routes->get('/indicators/delete/(:num)', 'IndicatorController::delete/$1');
});
