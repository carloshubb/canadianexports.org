<?php

use App\Http\Controllers\Auth\FileRegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

Route::get('/update/files/{slug}', [FileRegisterController::class, 'index'])->name('file-update.index');

if (config('app.env') !== 'local') {
    URL::forceScheme('https');
}
