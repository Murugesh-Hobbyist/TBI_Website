<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminKbArticleController;
use App\Http\Controllers\Admin\AdminLeadController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminProductMediaController;
use App\Http\Controllers\Admin\AdminProjectController;
use App\Http\Controllers\Admin\AdminProjectMediaController;
use App\Http\Controllers\Admin\AdminVideoController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\InstallController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/features', [SiteController::class, 'features'])->name('features');
Route::get('/solutions', [SiteController::class, 'solutions'])->name('solutions');
Route::get('/pricing', [SiteController::class, 'pricing'])->name('pricing');
Route::get('/about', [SiteController::class, 'about'])->name('about');
Route::get('/contact', [SiteController::class, 'contact'])->name('contact');
Route::post('/contact', [SiteController::class, 'submitContact'])->name('contact.submit');
Route::get('/quote', fn () => redirect()->route('contact'))->name('quote');
Route::post('/quote', [SiteController::class, 'submitQuote'])->name('quote.submit');

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');

Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');
Route::get('/videos/{video:slug}', [VideoController::class, 'show'])->name('videos.show');

// WooCommerce-style alias used on twinbot.in.
Route::get('/shop', [ProductController::class, 'index'])->name('shop');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products/{product}/enquiry', [ProductController::class, 'enquiry'])->name('products.enquiry');

Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// Pages present in twinbot.in sitemap but not implemented here.
Route::get('/hello-world', fn () => redirect()->route('home'))->name('hello-world');
Route::get('/my-account', fn () => redirect()->route('contact'))->name('my-account');
Route::get('/enquiry-cart', fn () => redirect()->route('products.index'))->name('enquiry-cart');

Route::get('/forum', [SiteController::class, 'forum'])->name('forum');

// One-time, token-protected installer for shared hosting (no SSH).
Route::get('/install', [InstallController::class, 'run'])->name('install');

Route::prefix('admin')->group(function () {
    // Name this route "login" so Laravel's auth middleware knows where to redirect.
    Route::get('/login', [AdminAuthController::class, 'show'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        Route::resource('projects', AdminProjectController::class)->names('admin.projects');
        Route::post('projects/{project}/media', [AdminProjectMediaController::class, 'store'])->name('admin.projects.media.store');
        Route::delete('projects/media/{media}', [AdminProjectMediaController::class, 'destroy'])->name('admin.projects.media.destroy');

        Route::resource('videos', AdminVideoController::class)->names('admin.videos');
        Route::resource('products', AdminProductController::class)->names('admin.products');
        Route::post('products/{product}/media', [AdminProductMediaController::class, 'store'])->name('admin.products.media.store');
        Route::delete('products/media/{media}', [AdminProductMediaController::class, 'destroy'])->name('admin.products.media.destroy');

        Route::resource('leads', AdminLeadController::class)->only(['index', 'show', 'destroy'])->names('admin.leads');
        Route::resource('orders', AdminOrderController::class)->only(['index', 'show'])->names('admin.orders');
        Route::resource('kb', AdminKbArticleController::class)->names('admin.kb');
    });
});
