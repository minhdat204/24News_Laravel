<?php

use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;
//user routes
Route::get('/', function () {
    return view('client.24new.index');
})->name('24new.index');
Route::get('/blog', function () {
    return view('client.24new.blog');
})->name('24new.blog');
Route::get('/contact', function () {
    return view('client.24new.contact');
})->name('24new.contact');
Route::get('/single', function () {
    return view('client.24new.single');
})->name('24new.single');

//admin routes
Route::get('/24news/admin', function () {
    return view('admin.pages.index');
})->name('admin.index');
Route::get('/24news/admin/flot', function () {
    return view('admin.pages.flot');
})->name('admin.flot');
Route::get('/24news/admin/morris', function () {
    return view('admin.pages.morris');
})->name('admin.morris');
Route::get('/24news/admin/table', function () {
    return view('admin.pages.table');
})->name('admin.table');
Route::get('/24news/admin/forms', function () {
    return view('admin.pages.forms');
})->name('admin.forms');
Route::get('/24news/admin/panel-wells', function () {
    return view('admin.pages.panel-wells');
})->name('admin.panel-wells');
Route::get('/24news/admin/buutons', function () {
    return view('admin.pages.buttons');
})->name('admin.buttons');
Route::get('/24news/admin/notifications', function () {
    return view('admin.pages.notifications');
})->name('admin.notifications');
Route::get('/24news/admin/typography', function () {
    return view('admin.pages.typography');
})->name('admin.typography');
Route::get('/24news/admin/icons', function () {
    return view('admin.pages.icons');
})->name('admin.icons');
Route::get('/24news/admin/grid', function () {
    return view('admin.pages.grid');
})->name('admin.grid');
Route::get('/24news/admin/blank', function () {
    return view('admin.pages.blank');
})->name('admin.blank');
Route::get('/24news/admin/login', function () {
    return view('admin.pages.login');
})->name('admin.login');


Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.showlogin');
Route::put('/admin/login', [AuthController::class, 'login'])->name('admin.login');
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::put('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');
    Route::get('/admin/dashboard', function () {
        return view('admin.pages.index');
        // return "Admin dashboard"; // This will be replaced by the actual dashboard view.
    })->name('admin.dashboard');
    Route::get('/admin/post', [PostController::class, 'index'])->name('admin.post');
    Route::post('/admin/post/hide/{id}', [PostController::class, 'hide'])->name('admin.post.hide');
    Route::put('/admin/post/update/{id}', [PostController::class, 'update'])->name('admin.post.update');
    Route::put('/admin/post/create', [PostController::class, 'store'])->name('admin.post.store');
});