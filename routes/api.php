<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\FinanceController;
use App\Http\Controllers\Api\ReportController;

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

// Public routes
Route::post('/authenticate', [ApiController::class, 'authenticate']);

// Protected routes (require API token)
Route::middleware('api.token')->group(function () {
    // API Management
    Route::get('/token/info', [ApiController::class, 'tokenInfo']);
    Route::post('/token/revoke', [ApiController::class, 'revokeToken']);
    Route::get('/rate-limit/info', [ApiController::class, 'rateLimitInfo']);
    
    // Admin only routes
    Route::middleware('api.admin')->group(function () {
        Route::get('/usage/stats', [ApiController::class, 'usageStats']);
        Route::get('/logs', [ApiController::class, 'logs']);
    });
    
    // Members
    Route::get('/members', [MemberController::class, 'index']);
    Route::post('/members', [MemberController::class, 'store']);
    Route::get('/members/{id}', [MemberController::class, 'show']);
    Route::put('/members/{id}', [MemberController::class, 'update']);
    Route::delete('/members/{id}', [MemberController::class, 'destroy']);
    Route::get('/members/statistics', [MemberController::class, 'statistics']);
    Route::get('/members/search', [MemberController::class, 'search']);
    Route::get('/members/{id}/contributions', [MemberController::class, 'contributions']);
    
    // Events
    Route::get('/events', [EventController::class, 'index']);
    Route::post('/events', [EventController::class, 'store']);
    Route::get('/events/{id}', [EventController::class, 'show']);
    Route::put('/events/{id}', [EventController::class, 'update']);
    Route::delete('/events/{id}', [EventController::class, 'destroy']);
    Route::get('/events/statistics', [EventController::class, 'statistics']);
    Route::get('/events/calendar', [EventController::class, 'calendar']);
    Route::post('/events/{id}/join', [EventController::class, 'join']);
    Route::post('/events/{id}/leave', [EventController::class, 'leave']);
    Route::get('/events/{id}/participants', [EventController::class, 'participants']);
    
    // Finance
    Route::get('/finance/contributions', [FinanceController::class, 'contributions']);
    Route::post('/finance/contributions', [FinanceController::class, 'storeContribution']);
    Route::get('/finance/contributions/{id}', [FinanceController::class, 'showContribution']);
    Route::put('/finance/contributions/{id}', [FinanceController::class, 'updateContribution']);
    Route::delete('/finance/contributions/{id}', [FinanceController::class, 'destroyContribution']);
    
    Route::get('/finance/expenses', [FinanceController::class, 'expenses']);
    Route::post('/finance/expenses', [FinanceController::class, 'storeExpense']);
    Route::get('/finance/statistics', [FinanceController::class, 'statistics']);
    Route::get('/finance/reports', [FinanceController::class, 'reports']);
    Route::get('/finance/budgets', [FinanceController::class, 'budgets']);
    
    // Reports
    Route::get('/reports/templates', [ReportController::class, 'templates']);
    Route::post('/reports/templates', [ReportController::class, 'storeTemplate']);
    Route::get('/reports/templates/{id}', [ReportController::class, 'showTemplate']);
    Route::put('/reports/templates/{id}', [ReportController::class, 'updateTemplate']);
    Route::delete('/reports/templates/{id}', [ReportController::class, 'destroyTemplate']);
    
    Route::post('/reports/generate', [ReportController::class, 'generate']);
    Route::get('/reports/generated', [ReportController::class, 'generated']);
    Route::get('/reports/generated/{id}', [ReportController::class, 'showGenerated']);
    Route::get('/reports/{id}/download', [ReportController::class, 'download']);
    Route::get('/reports/statistics', [ReportController::class, 'statistics']);
});

// Fallback route for undefined API endpoints
Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'API endpoint not found'
    ], 404);
});