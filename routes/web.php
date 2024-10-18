<?php

use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\SubscribeController;
use App\Http\Controllers\Admin\TagController;
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
        return view('admin.dashboard.index');
        // return "Admin dashboard"; // This will be replaced by the actual dashboard view.
    })->name('admin.dashboard');

    //posts
    Route::get('/admin/post', [PostController::class, 'index'])->name('admin.post');
    Route::post('/admin/post/hide/{id}', [PostController::class, 'hide'])->name('admin.post.hide');
    Route::put('/admin/post/update/{id}', [PostController::class, 'update'])->name('admin.post.update');
    Route::put('/admin/post/create', [PostController::class, 'store'])->name('admin.post.store');

    //contacts
    Route::get('/admin/contact', [ContactController::class, 'index'])->name('admin.contact');
    Route::put('/admin/contact/store', [contactController::class, 'store'])->name('admin.contact.store');
    Route::put('/admin/contact/{id}/update', [contactController::class, 'update'])->name('admin.contact.update');
    Route::put('/admin/contact/{id}/hide', [contactController::class, 'hide'])->name('admin.contact.hide');
    Route::put('/admin/contact/{id}/delete', [contactController::class, 'destroy'])->name('admin.contact.destroy');
    Route::put('/admin/contact/{id}/status', [contactController::class, 'updateStatus'])->name('admin.contact.status');


    //category
    Route::get('/admin/category', [CategoryController::class, 'index'])->name('admin.category');
    Route::put('/admin/category/store', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::put('/admin/category/{id}/update', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::put('/admin/category/{id}/hide', [CategoryController::class, 'hide'])->name('admin.category.hide');
    Route::delete('/admin/category/{id}/delete', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
    // Route::delete('/admin/category/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');



    //subscribe
    Route::get('/admin/subscribe', [SubscribeController::class, 'index'])->name('admin.subscribe');
    Route::put('/admin/subscribe/{id}/destroy', [SubscribeController::class, 'unSubscribed'])->name('admin.subscribe.destroy');
    Route::put('/admin/subscribe/{id}/update', [SubscribeController::class, 'update'])->name('admin.subscribe.update');
    Route::put('/admin/subscribe/store', [SubscribeController::class, 'store'])->name('admin.subscribe.store');
    Route::put('/admin/subscribers/bulk-actions', [SubscribeController::class, 'bulkActions'])->name('admin.subscribe.bulkActions');




    //tag
    Route::get('/admin/tag', [TagController::class, 'index'])->name('admin.tag');
    Route::put('/admin/tag/store', [tagController::class, 'store'])->name('admin.tag.store');
    Route::put('/admin/tag/{id}/update', [tagController::class, 'update'])->name('admin.tag.update');
    Route::put('/admin/tag/{id}/hide', [tagController::class, 'hide'])->name('admin.tag.hide');
    Route::delete('/admin/tag/{id}/delete', [tagController::class, 'destroy'])->name('admin.tag.destroy');

    //user
    Route::get('/admin/user', [ContactController::class, 'index'])->name('admin.user');
    Route::get('/admin/user/{id}/delete', [ContactController::class, 'deleteUser'])->name('admin.user.delete');
    Route::get('/admin/user/{id}/edit', [ContactController::class, 'editUser'])->name('admin.user.edit');
    Route::put('/admin/user/{id}/update', [ContactController::class, 'updateUser'])->name('admin.user.update');
});