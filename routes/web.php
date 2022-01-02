<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\FrontEnd\IndexController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\ProductController;

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



Route::group(['prefix'=> 'admin', 'middleware'=>['admin:admin']], function(){
	Route::get('/login', [AdminController::class, 'loginForm']);
	Route::post('/login',[AdminController::class, 'store'])->name('admin.login');
});




Route::middleware(['auth:sanctum,admin', 'verified'])->get('/admin/dashboard', function () {
    return view('admin.index');
})->name('dashboard');

Route::get('/admin/logout', [AdminController::class, 'destroy'])->name('admin.logout');
Route::get('/admin/profile', [AdminProfileController::class, 'admin_profile'])->name('admin.profile');
Route::get('/admin/profile/edit', [AdminProfileController::class, 'AdminProfileEdit'])->name('admin.profile.edit');
Route::post('/admin/profile/store', [AdminProfileController::class, 'AdminProfileStore'])->name('admin.profile.store');

Route::get('/admin/change/password', [AdminProfileController::class, 'AdminChangePassword'])->name('admin.change.password');
Route::post('/admin/update/password', [AdminProfileController::class, 'AdminUpdatePassword'])->name('update.change.password');

// FrontEnd Routes


Route::get('/', [IndexController::class, 'index']);

Route::middleware(['auth:sanctum,web', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/user/logout', [IndexController::class, 'userLogout'])->name('user.logout');
Route::get('/user/profile', [IndexController::class, 'userProfile'])->name('user.profile');
Route::post('/user/profile/store', [IndexController::class, 'userProfileStore'])->name('user.profile.store');
Route::get('/change/password', [IndexController::class, 'userChangePassword'])->name('change.password');
Route::post('/update/password', [IndexController::class, 'updatePassword'])->name('user.password.update');

Route::prefix('brand')->group(function(){

   Route::get('/view', [BrandController::class, 'view'])->name('brand.list');
   Route::post('/store', [BrandController::class, 'store'])->name('brand.store');
   Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('brand.edit');
   Route::post('/update/{id}', [BrandController::class, 'update'])->name('brand.update');
   Route::get('/delete/{id}', [BrandController::class, 'delete'])->name('brand.delete');  

});

Route::prefix('category')->group(function(){

   Route::get('/view', [CategoryController::class, 'view'])->name('category.list');
   Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
   Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
   Route::post('/update/{id}', [CategoryController::class, 'update'])->name('category.update');
   Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');

   Route::get('/view/subcategory', [SubCategoryController::class, 'subCategoryList'])->name('sub.category.list');
   Route::post('/store/subcategory', [SubCategoryController::class, 'store'])->name('subcategory.store');
  Route::get('/edit/subcategory/{id}', [SubCategoryController::class, 'subCategoryEdit'])->name('subcategory.edit');
   Route::post('/subcategory/update', [SubCategoryController::class, 'subCategoryUpdate'])->name('subcategory.update');
  Route::get('/subcategory/delete/{id}', [SubCategoryController::class, 'subCategoryDelete'])->name('subcategory.delete');

  /////////////  Sub-Sub Category   ////////////////////////////////
Route::get('/view/sub-subcategory', [SubCategoryController::class, 'subsubCategoryList'])->name('sub.subcategory.list');
Route::get('/subcategory/ajax/{id}', [SubCategoryController::class, 'getSubCategory']);
Route::get('/sub-subcategory/ajax/{subcategory_id}', [SubCategoryController::class, 'GetSubSubCategory']);
Route::post('/store/sub-subcategory', [SubCategoryController::class, 'subsubCategoryStore'])->name('subsubcategory.store');
Route::get('/edit/sub-subcategory/{id}', [SubCategoryController::class, 'subsubCategoryEdit'])->name('subsubcategory.edit');
Route::get('/delete/sub-subcategory/{id}', [SubCategoryController::class, 'subsubCategoryDelete'])->name('subsubcategory.delete');


});

Route::prefix('product')->group(function(){

   Route::get('/add', [ProductController::class, 'addProduct'])->name('product.add');
   Route::post('/store', [ProductController::class, 'storeProduct'])->name('product-store');
   Route::get('/list', [ProductController::class, 'manageProduct'])->name('product.list');
   Route::get('/edit/{id}', [ProductController::class, 'editProduct'])->name('product.edit');
    

});
