<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\Products\ProductsController;
use Illuminate\Support\Facades\Route;




Route::group(["middleware"=>"auth"] , function(){
    Route::get("/" , [DashboardController::class,"index"]);
});
Route::group(["prefix"=>"dashboard","middleware"=>"auth"],function(){
    Route::get("/" , [DashboardController::class,"index"])->name("dashboard");
    Route::group(["prefix"=>"products" , "as"=>"product."],function(){
        Route::get("/" , [ProductsController::class,"index"])->name("index");
        Route::get("/create" , [ProductsController::class,"create"])->name("create");
        Route::post("/store" , [ProductsController::class,"store"])->name("store");
        Route::get("/edit/{id}" , [ProductsController::class,"edit"])->name("edit");
        Route::put("/update/{id}" , [ProductsController::class,"update"])->name("update");
        Route::delete("/delete/{id}" , [ProductsController::class,"delete"])->name("delete");

    });
    Route::group(["prefix"=>"brands" , "as"=>"brand."],function(){
        Route::get("/" , [BrandController::class,"index"])->name("index");
        Route::get("/create" , [BrandController::class,"create"])->name("create");
        Route::post("/store" , [BrandController::class,"store"])->name("store");
        Route::get("/edit/{id}" , [BrandController::class,"edit"])->name("edit");
        Route::put("/update/{id}" , [BrandController::class,"update"])->name("update");
        Route::delete("/delete/{id}" , [BrandController::class,"delete"])->name("delete");

    });
    Route::group(["prefix"=>"categories" , "as"=>"category."],function(){
        Route::get("/" , [CategoryController::class,"index"])->name("index");
        Route::get("/create" , [CategoryController::class,"create"])->name("create");
        Route::post("/store" , [CategoryController::class,"store"])->name("store");
        Route::get("/edit/{id}" , [CategoryController::class,"edit"])->name("edit");
        Route::put("/update/{id}" , [CategoryController::class,"update"])->name("update");
        Route::delete("/delete/{id}" , [CategoryController::class,"delete"])->name("delete");

    });
    Route::group(["prefix"=>"orders" , "as"=>"order."],function(){
        Route::get("/" , [OrdersController::class,"index"])->name("index");
        Route::get("/detalis/{id}" , [OrdersController::class,"detalis"])->name("detalis");

    });
});


Auth::routes();



