<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PagesAddController;
use App\Http\Controllers\PagesEditController;
use App\Http\Controllers\PortfoliosController;
use App\Http\Controllers\PortfoliosAddController;
use App\Http\Controllers\PortfoliosEditController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ServicesAddController;
use App\Http\Controllers\ServicesEditController;

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

Route::middleware(['web'])->group(function() {

    Route::match(['get','post'],'/',[IndexController::class, 'execute'])->name('home');
    Route::get('/page/{alias}',[PageController::class, 'execute'])->name('page');

});

//admin/service

Route::middleware(['web'])->prefix('admin')->group(function ()
{
    // admin panel
    Route::get('/',function() {
        if(view()->exists('admin.index')) {
            $data = ['title' => 'Панель администратора'];
            return view('admin.index',$data);
        }
    })->middleware(['auth'])->name('home');

    //admin/pages
    Route::prefix('pages')->group(function ()
    {
        //admin/pages
        Route::get('/',[PagesController::class, 'execute'])->name('pages');

        //admin/pages/add
        Route::match(['get','post'],'/add',[PagesAddController::class, 'execute'])->name('pagesAdd');
        //admin/edit/2
        Route::match(['get','post','delete'],'/edit/{page}',[PagesEditController::class, 'execute'])->name('pagesEdit');

    });


    //admin/portfolios
    Route::prefix('portfolios')->group(function () {


        Route::get('/', [PortfoliosController::class, 'execute'])->name('portfolios');


        Route::match(['get','post'],'/add', [PortfoliosAddController::class, 'execute'])->name('portfoliosAdd');

        Route::match(['get','post','delete'],'/edit/{portfolio}', [PortfoliosEditController::class, 'execute'])->name('portfoliosEdit');

    });


    //admin/services
    Route::prefix('services')->group(function () {


        Route::get('/', [ServicesController::class, 'execute'])->name('services');


        Route::match(['get','post'],'/add', [ServicesAddController::class, 'execute'])->name('servicesAdd');

        Route::match(['get','post','delete'],'/edit/{service}', [ServicesEditController::class, 'execute'])->name('servicesEdit');

    });

});



require __DIR__.'/auth.php';
