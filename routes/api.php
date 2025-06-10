<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication;  // Corrected namespace for Authentication controller
use App\Http\Controllers\Zoho; 
// Define the 'authenticate' route using the Authentication controller


Route::post('authenticate', [Authentication::class, 'authenticate']);
Route::post('forgetPassword', [Authentication::class, 'forgetPassword']);
Route::post('checkMobileExist', [Authentication::class, 'checkMobileExist']);
Route::post('updatePassword', [Authentication::class, 'updatePassword']);
Route::get('/getUsers/{gender?}/{featured?}', [Authentication::class, 'getUsers']);
Route::get('/search_user/{religion_id?}/{caste_id?}/{height_start?}/{height_end?}', [Authentication::class, 'search_user']);
Route::get('/user_with_caste/{gender?}/{caste_id?}', [Authentication::class, 'user_with_caste']);
Route::get('/single_user/{id?}/{viewed_member_id?}', [Authentication::class, 'single_user']);

# Chat Apii
Route::get('/settings/{id?}', [Authentication::class, 'settings']);
Route::get('/my_profile/{user_id?}', [Authentication::class, 'my_profile']);
Route::get('/notifications/{user_id?}', [Authentication::class, 'notifications']);
Route::get('/pages/{page_id?}', [Authentication::class, 'pages']);
Route::get('/packages', [Authentication::class, 'packages']);
Route::get('/getSuccessStories', [Authentication::class, 'getSuccessStories']);
Route::get('/fetchReligion/{religion_id?}', [Authentication::class, 'fetchReligion']);
Route::get('/fetchCaste/{religion_id?}', [Authentication::class, 'fetchCaste']);
Route::get('/fetchGender', [Authentication::class, 'fetchGender']);
Route::get('/fetchCreated_by', [Authentication::class, 'fetchCreated_by']);
Route::get('/fetchOccupations', [Authentication::class, 'fetchOccupations']);
Route::get('/fetchIncome', [Authentication::class, 'fetchIncome']);
Route::get('/fetchHeight', [Authentication::class, 'fetchHeight']);
Route::get('/fetchMarital_status', [Authentication::class, 'fetchMarital_status']);
Route::get('/getMembersShortFavourite/{from_id?}/{flag?}', [Authentication::class, 'getMembersShortFavourite']);
Route::post('contact_us', [Authentication::class, 'contact_us']);
Route::post('user', [Authentication::class, 'user']);
Route::get('/chats_member/{member_id?}', [Authentication::class, 'chats_member']);
Route::get('/chats/{member_id?}/{sender_user_id?}', [Authentication::class, 'chats']);
Route::post('chatsData/{member_id?}/{to_user_id?}', [Authentication::class, 'chatsData']);
Route::post('profileRequest', [Authentication::class, 'profileRequest']);
Route::post('paymentUpdate', [Authentication::class, 'paymentUpdate']);

Route::post('user_update', [Authentication::class, 'user_update']);
/*
Route::post('check_forget', [Authentication::class, 'check_forget']);
Route::post('update_forget_password', [Authentication::class, 'update_forget_password']);
Route::post('signup', [Authentication::class, 'signup']);
Route::post('uploadComplaintsFile', [Authentication::class, 'uploadComplaintsFile']);
Route::post('uploadSuggestion', [Authentication::class, 'uploadSuggestion']);
Route::post('get_complaint_data', [Authentication::class, 'get_complaint_data']);
Route::post('get_suggestion_data', [Authentication::class, 'get_suggestion_data']);*/




// Zoho working
Route::post('get_zoho_token', [Zoho::class, 'get_zoho_token']);

// Define a protected route that returns the authenticated user
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
