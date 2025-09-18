
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/letters', LetterController::class);
Route::get('letters/{letter}/download', [LetterController::class, 'download'])->name('letters.download');
Route::get('letters/{letter}/view', [LetterController::class, 'viewPdf'])->name('letters.view');
Route::resource('categories', CategoryController::class);
Route::view('/about', 'about');
