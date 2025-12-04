<?php

use App\Http\Controllers\Auth\FileRegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/update/files/{slug}', [FileRegisterController::class, 'index'])->name('file-update.index');

if (env('APP_ENV') != 'local') {
    URL::forceScheme('https');
}
