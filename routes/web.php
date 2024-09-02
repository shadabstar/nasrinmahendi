<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\CometChatController;
use App\Http\Controllers\serviceProvider\DashboardController;
use App\Http\Controllers\serviceProvider\OrderController;
use App\Http\Controllers\ServiceProvider\ServiceController as serviceProviderService;
use App\Http\Controllers\serviceProvider\socialMediaAuth;
use App\Http\Controllers\SubAdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\serviceProvider\AuthController as serviceProviderAuth;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\serviceProvider\BusinessController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/auth/google/callback", [socialMediaAuth::class, "googleHandle"])->name("google-handler");
Route::get("/", [serviceProviderAuth::class, "loginGet"])->name("service-provider-loginget");
Route::prefix("serviceprovider")->group(function () {
    Route::get("/google-login", [socialMediaAuth::class, "googleLogin"])->name("google-login");


    Route::post("/login", [serviceProviderAuth::class, "loginPost"])->name("service-provider-loginpost");
    Route::get("/signup", [serviceProviderAuth::class, "create"])->name("service-provider-create");
    Route::post("/signup", [serviceProviderAuth::class, "store"])->name("service-provider-store");
    Route::get("/otp", [serviceProviderAuth::class, "otpPage"])->name("service-provider-otp");
    Route::post("/varification", [serviceProviderAuth::class, "varification"])->name("varify-otp");
    Route::post("/verified", [serviceProviderAuth::class, "varifiedOtp"])->name("varified-otp");
    Route::get("/resend-otp", [serviceProviderAuth::class, "resendOtp"])->name("resend-otp");


    // Route::post("/")

    Route::middleware(["auth"])->group(function () {
        Route::get("/", [DashboardController::class, "index"])->name("service-provider-dashboard");

        Route::get("/change-password", [serviceProviderAuth::class, "changePasswordGet"])->name("service-provider-password");
        Route::post("/chage-password", [serviceProviderAuth::class, "ChangePasswordPost"])->name("service-provider-change-password");



        // Route::prefix("business")->group(function () {
        //     Route::get("/create", [BusinessController::class, "create"])->name("business-create");
        //     Route::post("/store", [BusinessController::class, "store"])->name("business-store");
        //     Route::get("/edit/{id}", [BusinessController::class, "edit"])->name("business-edit");
        //     Route::put("/{id}", [BusinessController::class, "update"])->name("business-update");
        // });

        Route::prefix("order")->group(function () {
            Route::get("/list", [OrderController::class, "index"])->name("order-list");
            Route::get("/data", [OrderController::class, "orderData"])->name("order-data");
            Route::get("/create", [OrderController::class, "create"])->name("order-create");
            Route::post("/store", [OrderController::class, "store"])->name("order-store");
            Route::post("/update/{id}", [OrderController::class, "update"])->name("order-update");
            Route::post("/update-member", [OrderController::class, "updateMember"])->name("order-update-member");
            Route::post("/delete-member", [OrderController::class, "deleteMember"])->name("order-delete-member");
            Route::post("/delete-image", [OrderController::class, "deleteImage"])->name("order-delete-image");
            Route::get("/edit/{id}", [OrderController::class, "edit"])->name("service-edit");
            Route::get("/status", [OrderController::class, "changeStatus"])->name("order-status");
            Route::get("/delete", [OrderController::class, "delete"])->name("order-delete");
            Route::post("/payment-status", [OrderController::class, "payOrUnPay"])->name("order.paid.status");

        });


        // Route::prefix("service")->group(function () {
        //     Route::get("/list", [serviceProviderService::class, "index"])->name("service-list");
        //     Route::get("/data", [serviceProviderService::class, "serviceData"])->name("service-data");
        //     Route::get("/edit/{id}", [serviceProviderService::class, "edit"])->name("service-edit");
        //     Route::put("/{id}", [serviceProviderService::class, "update"])->name("service-update");
        //     Route::get("/create", [serviceProviderService::class, "create"])->name("service-create");
        //     Route::post("/store", [serviceProviderService::class, "store"])->name("user-service-store");
        //     Route::get("/delete", [serviceProviderService::class, "delete"])->name("service-delete");
        //     Route::get("/status", [serviceProviderService::class, "changeStatus"])->name("service-status");
        //     Route::get("/get-service", [serviceProviderService::class, "serviceByCategory"])->name("by-category");
        // });

        Route::get("/logout", [serviceProviderAuth::class, "logout"])->name("logout");


    });
});

// $2y$12$2zzx7VxMhF8CkZeUJqQYouP1G0X6sVGxqTBsH84Zx8iiDyeh9eS4y
// $2y$12$V.JUwOgzIcRkW5h3m5rWxOiz0D6JwEsfQbPLw6HdOqO5k0oISZLJS
