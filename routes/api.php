<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnouncementController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/Announcement', [AnnouncementController::class, 'index']);
Route::get('/Announcement/get_announcement_types', [AnnouncementController::class, 'get_announcement_types']);
Route::get('/Announcement/get_all_announcements', [AnnouncementController::class, 'get_all_announcements']);

Route::post('/Announcement/delete', [AnnouncementController::class, 'delete']);
Route::post('/Announcement/manage', [AnnouncementController::class, 'manage']);
Route::post('/Announcement/get_announcement', [AnnouncementController::class, 'get_announcement']);