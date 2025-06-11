<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/blogs/{slug}', [HomeController::class, 'show'])->name('blogs.show');
Route::post('/usercomment', [HomeController::class, 'store'])->name('usercomment.store');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//==== Admin route==//
Route::group(['namespace' => '\App\Http\Controllers\Admin'], function () {
    
    Route::post('forgot', ['uses' => 'AdminController@postForgot', 'as' => 'postForgot']);
    Route::get('forgot', ['uses' => 'AdminController@getForgot', 'as' => 'getForgot']);
    //Route::post('register', ['uses' => 'AdminController@postRegister', 'as' => 'postRegister']);
   // Route::get('register', ['uses' => 'AdminController@getRegister', 'as' => 'register']);
    Route::get('logout', ['uses' => 'AdminController@getLogout', 'as' => 'getLogout']);
    //Route::post('login', ['uses' => 'AdminController@postLogin', 'as' => 'postLogin']);
    //Route::get('login', ['uses' => 'AdminController@getLogin', 'as' => 'login']);
    Route::get('admin/login', ['uses' => 'AdminController@getAdminLogin', 'as' => 'getAdminLogin']);
    Route::post('admin/login', ['uses' => 'AdminController@postAdminLogin', 'as' => 'postAdminLogin']);
});

Route::group(['middleware' => ['admin.auth'], 'namespace' => '\App\Http\Controllers\Admin'], function () {
    Route::get('/admin', ['uses' => 'AdminController@getIndex', 'as' => 'getIndex']);
    Route::get('admin/dashboard', ['uses' => 'AdminController@getIndex', 'as' => 'getAdminDashboard']);
    Route::get('admin/dashboard', ['uses' => 'AdminController@getIndex', 'as' => 'getAdminProfile']);
    

    //Admin Users
    Route::get('admin-users', ['uses' => 'AdminUsersController@getIndex', 'as' => 'getAdminUsers']);
    Route::get('admin-users/add', ['uses' => 'AdminUsersController@getAdd', 'as' => 'getAddAdminUser']);
    Route::post('admin-users/add-save', ['uses' => 'AdminUsersController@postAddSave', 'as' => 'postAddSaveAdminUser']);
    Route::get('admin-users/edit/{id}', ['uses' => 'AdminUsersController@getEdit', 'as' => 'getEditAdminUser']);
    Route::post('admin-users/update-save/{id}', ['uses' => 'AdminUsersController@postUpdateSave', 'as' => 'postUpdateSaveAdminUser']);
    Route::get('admin-users/delete/{id}', ['uses' => 'AdminUsersController@getDelete', 'as' => 'getDeleteAdminUser']);


    //Download & Delete File
    Route::get('download-file', 'AdminController@download_file');
    Route::get('delete-image', 'AdminController@delete_file');

    //admin profile
    Route::get('profile', ['uses' => 'ProfileController@getProfileData', 'as' => 'getProfileData']);
    Route::post('save-profile', ['uses' => 'ProfileController@postSaveProfile', 'as' => 'postSaveProfile']);


    //Manage Banner
    Route::get('manage-banner', ['uses' => 'ManageBannerController@getIndex', 'as' => 'getManageBanner']);
    Route::get('manage-banner/add', ['uses' => 'ManageBannerController@getAdd', 'as' => 'getAddBanner']);
    Route::post('manage-banner/add-save', ['uses' => 'ManageBannerController@postAddSave', 'as' => 'postAddBanner']);
    Route::get('manage-banner/detail/{id}', ['uses' => 'ManageBannerController@getDetail', 'as' => 'getDetailBanner']);
    Route::get('manage-banner/edit/{id}', ['uses' => 'ManageBannerController@getEdit', 'as' => 'getEditBanner']);
    Route::post('manage-banner/edit-save/{id}', ['uses' => 'ManageBannerController@postUpdateSave', 'as' => 'postUpdateBanner']);
    Route::get('manage-banner/delete/{id}', ['uses' => 'ManageBannerController@getDelete', 'as' => 'deleteBanner']);
    Route::post('manage-banner/action-selected', ['uses' => 'ManageBannerController@postActionSelected', 'as' => 'actionSelectedBanner']);

    //Manage BLOG
    Route::get('manage-blog', ['uses' => 'ManageBlogController@getIndex', 'as' => 'getManageBlog']);
    Route::get('manage-blog/add', ['uses' => 'ManageBlogController@getAdd', 'as' => 'getAddBlog']);
    Route::post('manage-blog/add-save', ['uses' => 'ManageBlogController@postAddSave', 'as' => 'postAddBlog']);
    Route::get('manage-blog/detail/{id}', ['uses' => 'ManageBlogController@getDetail', 'as' => 'getDetailBlog']);
    Route::get('manage-blog/edit/{id}', ['uses' => 'ManageBlogController@getEdit', 'as' => 'getEditBlog']);
    Route::post('manage-blog/edit-save/{id}', ['uses' => 'ManageBlogController@postUpdateSave', 'as' => 'postUpdateBlog']);
    Route::get('manage-blog/delete/{id}', ['uses' => 'ManageBlogController@getDelete', 'as' => 'deleteBlog']);
    Route::post('manage-blog/action-selected', ['uses' => 'ManageBlogController@postActionSelected', 'as' => 'actionSelectedBlog']);
});