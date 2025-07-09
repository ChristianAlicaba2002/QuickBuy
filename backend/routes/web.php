<?php

use App\Domain\Order\Order;
use App\Models\Orders;
use App\Models\Archive;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Product\ProductController;

Route::get('/', function () {
    if (Auth::guard('admin')->check()) {
        return redirect()->route('dashboard');
    } else {
        return view('welcome');
    }
})->name('admin_login_page')->middleware(PreventBackHistory::class);


Route::middleware(['auth:admin'])->group(function () {

    Route::get('/dashboard', function () {
        //Retrieve all the products
        $products = Products::orderBy('created_at', 'desc')->get();

        //Get the product if the stock it's less than or equal to 10
        $lowStockCount = Products::where('stock', '<=', 10)->count();

        //Get all the orders that have been accepted
        $getAllOrders = Orders::where('status' ,'=', 'accepted')->count();

        return view('pages.dashboard', compact('products', 'lowStockCount','getAllOrders'));
    })->name('dashboard')->middleware(PreventBackHistory::class, AdminMiddleware::class);

    Route::view('/user-management', 'pages.userManagement')->name('user-management');

    Route::get("/order-pending", function () {
        $orders = Orders::orderBy('created_at', 'desc')->get();

        return view('pages.orderPending', compact('orders'));

    })->name('order-pending')->middleware(AdminMiddleware::class);

    Route::get('/archive', function () {
        $archiveProducts = Archive::orderBy('created_at', 'desc')->get();
        return view('pages.archive', compact('archiveProducts'));
    })->name('archive')->middleware(AdminMiddleware::class);
});


//Admin Authentication
Route::post('/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

//Product Routes
Route::post('/create', [ProductController::class, 'create'])->name('create.product');
Route::delete('/delete/{id}', [ProductController::class, 'delete'])->name('delete.product');
Route::delete('/archive/{id}', [ProductController::class, 'archive'])->name('archive.product');
Route::delete('/restore/{id}', [ProductController::class, 'restore'])->name('restore.product');
Route::put('/update/{id}', [ProductController::class, 'update'])->name('update.product');

//Orders Routes
Route::post('pending-order/{id}', [OrderController::class, 'acceptTheUserOrder'])->name('pending.order');
