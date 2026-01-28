<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Shop
Route::get('/shop', [App\Http\Controllers\ShopController::class, 'index'])->name('shop.index');

// Trends
// Trends
Route::get('/trends', [App\Http\Controllers\TrendsController::class, 'index'])->name('trends.index');

// Compare
Route::get('/compare', [App\Http\Controllers\CompareController::class, 'index'])->name('compare.index');
Route::get('/api/compare/products', [App\Http\Controllers\CompareController::class, 'products'])->name('compare.products');

// Blog
Route::get('/blog', [App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');

// Search
Route::get('/api/search', [App\Http\Controllers\SearchController::class, 'search'])->name('api.search');

// Notifications
Route::get('/api/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('api.notifications');
Route::get('/api/notifications/count', [App\Http\Controllers\NotificationController::class, 'count'])->name('api.notifications.count');




// Categories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// Products
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('products.show');

// Deals
Route::get('/deals', [DealController::class, 'index'])->name('deals.index');
Route::get('/deal/{slug}', [DealController::class, 'show'])->name('deals.show');

// Static Pages
Route::get('/about', [PageController::class, 'about'])->name('pages.about');
Route::get('/affiliate-disclosure', [PageController::class, 'disclosure'])->name('pages.disclosure');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('pages.privacy');
Route::get('/contact', [PageController::class, 'contact'])->name('pages.contact');
Route::post('/contact', [PageController::class, 'sendContact'])->name('pages.contact.send');

// Voyager Admin Routes
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
