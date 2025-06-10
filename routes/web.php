<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
Route::get('/', function () {
    return redirect()->route('login');
   
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

#b Report Section
Route::get('/blank', [HomeController::class, 'blank'])->name('blank');
Route::get('/contact_us', [HomeController::class, 'blank'])->name('contact_us');
Route::get('/report_members', [HomeController::class, 'report_members'])->name('report_members');
Route::get('/castewise_data/{caste_id?}', [HomeController::class, 'castewise_data'])->name('castewise_data');
Route::get('/genderwise_data/{gender_id?}', [HomeController::class, 'genderwise_data'])->name('genderwise_data');
Route::get('/report_users', [HomeController::class, 'report_users'])->name('report_users');
Route::get('/report_religions', [HomeController::class, 'report_religions'])->name('report_religions');
Route::get('/report_caste', [HomeController::class, 'report_caste'])->name('report_caste');
Route::get('/report_gender', [HomeController::class, 'report_gender'])->name('report_gender');
Route::get('/report_height', [HomeController::class, 'report_height'])->name('report_height');
Route::get('/report_packages', [HomeController::class, 'report_packages'])->name('report_packages');
Route::get('/report_marital_status', [HomeController::class, 'report_marital_status'])->name('report_marital_status');
Route::get('/report_occupations', [HomeController::class, 'report_occupations'])->name('report_occupations');
Route::get('/report_created_by', [HomeController::class, 'report_created_by'])->name('report_created_by');
Route::get('/report_income', [HomeController::class, 'report_income'])->name('report_income');

# Form actions

Route::POST('/deleteRecords', [HomeController::class, 'deleteRecords'])->name('deleteRecords');
Route::POST('/save_religion', [HomeController::class, 'save_religion'])->name('save_religion');
Route::POST('/save_caste', [HomeController::class, 'save_caste'])->name('save_caste');
Route::POST('/save_gender', [HomeController::class, 'save_gender'])->name('save_gender');
Route::POST('/save_height', [HomeController::class, 'save_height'])->name('save_height');
Route::POST('/save_packages', [HomeController::class, 'save_packages'])->name('save_packages');
Route::POST('/save_marital_status', [HomeController::class, 'save_marital_status'])->name('save_marital_status');
Route::POST('/save_occupations', [HomeController::class, 'save_occupations'])->name('save_occupations');
Route::POST('/save_created_by', [HomeController::class, 'save_created_by'])->name('save_created_by');
Route::POST('/save_income', [HomeController::class, 'save_income'])->name('save_income');


# Edit Actions
Route::get('/edit_caste/{caste_id?}', [HomeController::class, 'edit_caste'])->name('edit_caste');
Route::get('/add_caste', [HomeController::class, 'add_caste'])->name('add_caste');
Route::POST('/save_edit_castes', [HomeController::class, 'save_edit_castes'])->name('save_edit_castes');


Route::get('/edit_packages/{pakage_id?}', [HomeController::class, 'edit_packages'])->name('edit_packages');
Route::get('/add_packages', [HomeController::class, 'add_packages'])->name('add_packages');
Route::POST('/save_packages', [HomeController::class, 'save_packages'])->name('save_packages');


# Edit Profile


# Manually package Add to user 