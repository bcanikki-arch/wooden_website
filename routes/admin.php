<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Homes\HomesController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\SubCategory\SubCategoryController;
use App\Http\Controllers\Admin\Customer\CustomerController;
use App\Http\Controllers\Admin\Blog\BlogController;
use App\Http\Controllers\Admin\ProductType\ProductTypeController;
use App\Http\Controllers\Admin\Brand\BrandController;
use App\Http\Controllers\Admin\Stock\StockController;
use App\Http\Controllers\Admin\Invoice\InvoiceController;
use App\Http\Controllers\Admin\Sale\SalesController;
use App\Http\Controllers\Admin\Testimonial\TestimonialController;
use App\Http\Controllers\Admin\Service\ServiceController;
use App\Http\Controllers\Admin\Cms\CmsController;
use App\Http\Controllers\Admin\Setting\SettingController;
use App\Http\Controllers\Admin\Sitesetting\SiteSettingController;

Route::prefix('admin')
    ->middleware(['web', 'admin'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [HomesController::class, 'index'])
            ->name('admin.dashboard');

        // Logout
        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('admin.logout');

        // Profile
        Route::get('/profile', [AuthController::class, 'profile'])
            ->name('admin.profile');

        Route::post('/profile/update', [AuthController::class, 'updateprofile'])
            ->name('admin.profile.update');

        // PRODUCTS
        Route::resource('product', ProductController::class);

        // STOCK
        Route::resource('stock', StockController::class);

        // CATEGORY
        Route::resource('category', CategoryController::class);

        // SUBCATEGORY
        Route::resource('subcategory', SubCategoryController::class);

        // CUSTOMER
        Route::resource('customer', CustomerController::class);

        // BLOG
        Route::resource('blog', BlogController::class);

        // CMS
        Route::resource('cms', CmsController::class);

        // SERVICE
        Route::resource('service', ServiceController::class);

        // BRAND
        Route::resource('brand', BrandController::class);

        // PRODUCT TYPE
        Route::resource('product-type', ProductTypeController::class);

        // INVOICE
        Route::resource('invoice', InvoiceController::class);

        Route::get('/invoice/{id}/download', [InvoiceController::class, 'downloadInvoice'])
            ->name('admin.invoice.download');

        // SALES
        Route::get('/sales', [SalesController::class, 'index'])
            ->name('admin.sales.index');

        // SETTINGS
        Route::get('/socials', [SettingController::class, 'index'])
            ->name('admin.social');
        Route::post('/socials/store', [SettingController::class, 'store']);

        Route::get('/sitesetting/create', [SiteSettingController::class, 'create']);
        Route::post('/sitesetting/store', [SiteSettingController::class, 'store']);
    });
