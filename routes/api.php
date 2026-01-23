<?php

use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\SourceController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function (): void {
    Route::get('/leads', [LeadController::class, 'index']);
    Route::post('/leads', [LeadController::class, 'store']);

    Route::get('/sources', [SourceController::class, 'index']);
    Route::post('/sources', [SourceController::class, 'store']);

    Route::post('/leads/{lead}/proposals', [ProposalController::class, 'store']);
});
