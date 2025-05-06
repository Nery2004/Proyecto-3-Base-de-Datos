<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('reports')->name('reports.')->group(function(){
    Route::get('/', [ReportController::class,'index'])->name('index');
    Route::get('pdf', [ReportController::class,'exportPdf'])->name('exportPdf');
    Route::get('excel', [ReportController::class,'exportExcel'])->name('exportExcel');
});
