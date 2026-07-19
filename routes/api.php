<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProgramKBController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

Route::post('/auth/login',[AuthController::class, 'login']);

Route::middleware('auth:sanctum')->prefix('auth')->group(function () 
{
    Route::post('logout',[AuthController::class, 'logout']);   
});

Route::middleware(['auth:sanctum', 'permission:role.permission.manage'])->prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index']);
        Route::get('/{role}', [RoleController::class, 'show']);
        Route::put('/{role}/permissions', [RoleController::class, 'updatePermissions']);
});

Route::middleware('auth:sanctum')->group(function(){
    /* Knowledge Base */
    Route::get( '/program-kb', [ProgramKBController::class,'index'] )->middleware('permission:program-kb.view');
    Route::post( '/program-kb', [ProgramKBController::class,'store'] )->middleware('permission:program-kb.create');
    Route::put('/program-kb/{programKB}',[ProgramKBController::class,'update'])->middleware('permission:program-kb.edit');
    Route::delete( '/program-kb/{programKB}',[ProgramKBController::class,'destroy'])->middleware('permission:program-kb.delete');
});

Route::middleware('auth:sanctum')->prefix('user')->group(function () {
    Route::post('create',[UserController::class, 'store'])->middleware('permission:user.create');
    Route::get('/',[UserController::class, 'index'])->middleware('permission:user.view');
    Route::get('/{user}',[UserController::class, 'show'])->middleware('permission:user.view');
    Route::put('/{user}',[UserController::class, 'update'])->middleware('permission:user.edit');
    Route::delete('/{user}',[UserController::class, 'destroy'])->middleware('permission:user.delete');
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get( '/chat-sessions', [ChatController::class, 'index'] );
    Route::post( '/chat-sessions', [ChatController::class, 'create'] );
    Route::get( '/chat-sessions/{chatSession}', [ChatController::class, 'show']);
    Route::post( '/chat-sessions/{chatSession}/messages', [ChatController::class, 'send']);
    Route::post( '/chat-sessions/{chatSession}/support-reply', [ChatController::class, 'sendSupportReply']);
    Route::delete( '/chat-sessions/{chatSession}', [ChatController::class, 'destroy']);
    Route::patch( '/chat-sessions/{chatSession}/resolve', [ChatController::class, 'resolve'] );
});

Route::middleware(['auth:sanctum','permission:dashboard.view'])->group(function () {

    Route::get( '/dashboard/metrics', [DashboardController::class, 'index'] );

});

