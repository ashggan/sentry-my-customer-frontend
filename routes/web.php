<?php

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

Route::get('/', function() {
    return view('home');
})->name('home');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/admin', function() {
    return redirect()->route('dashboard');
});

// backend codes

Route::prefix('/admin')->group(function () {
    Route::get('/login', ['uses' => "Auth\LoginController@index"])->name('login');
    Route::post('/login/authenticate', ['uses' => "Auth\LoginController@authenticate"])->name('login.authenticate');


    Route::get('/register', 'Auth\RegisterController@index')->name('signup');

    Route::post('/register', 'Auth\RegisterController@register')->name('register');
    Route::get('/logout', 'Auth\LogoutController@index')->name('logout');

});

// Protected Routes
Route::group(['prefix' => '/admin', 'middleware' => 'backend.auth'], function () {
    Route::get('/activate', 'ActivateController@index')->name('activate.user');

    // dashboard
    Route::get('/dashboard', function () {
        return view('backend.dashboard');
    })->name('dashboard');

    // Customers
    Route::get('/customers', function () {
        return view('backend.customers.index');
    })->name('customers');

    // Creditors
    Route::get('/creditor/add', function () {
        return view('backend.creditors.add');
    })->name('add_creditor');

    //Single Customer view
    Route::get('/singleCustomer', function(){
        return view('backend.customers.singleCustomer');
    })->name('customer');

    // transaction

    Route::get('/transactions', function () {
        return view('backend.transactions.index');
    })->name('transactions');

    Route::get('/broadcast', function () {
        return view('backend.broadcasts.send_broadcast');
    })->name('broadcast');

    // Route::get('/backend/view_transaction/{{$id}}', function () {
    //     return view('backend.transactions.show');
    // });

    Route::get('/transactions/{id}', 'SingleTransactionController@index')->name('view_transaction');

    Route::get('/users', 'UsersController@index')->name('users');
    Route::get('/users/{id}', 'UsersController@show')->name('user.view');


    Route::get('/debt_reminders', function () {
        return view('backend.debt_reminder.index');
    })->name('debts.reminder');


    Route::get('/complaint', function () {
        return view('backend.complaints.complaintform');
    })->name('complaint.form');

    // Route::get('/complaint_log', function () {
    //     return view('backend.complaints.complaintlog');
    // })->name('complaint.log');
    Route::get('/complaint_log', 'ComplaintController@index');


    Route::get('/change-loc', function () {
        return view('backend.location.change_loc');
    });

    // all users
    // duplicate routes

    // Route::get('/users_list', function () {
    //     return view('users_list.single_user');
    // })->name('users.list');

    // Route::get('/view_user', function () {
    //     return view('backend.users_list.show');
    // })->name('user.view');

    // analytics
    Route::get('/analytics', function () {
        return view('backend.analytics.analytics');
    })->name('analytics');

    // stores
    Route::get('/stores', function () {
        return view('backend.stores.store_list');
    })->name('stores');

    Route::get('/create_store', function () {
        return view('backend.stores.create');
    })->name('store.create');


    Route::get('/view_store', function () {
        return view('backend.stores.show');
    })->name('store.view');

    Route::get('/edit_store', function () {
        return view('backend.stores.edit');
    })->name('store.edit');

    Route::get('/settings', 'SettingsController@index')->name('settings');

    Route::post('/settings', 'SettingsController@update')->name('settings.update');

    Route::get('/edit_assistants', function () {
        return view('backend.store-assistants.edit_assistants');
    })->name('assistants.edit');


    // assistant
    Route::get('/add_assistant', function () {
        return view('backend.store-assistants.add_assistant');
    })->name('assistants.add');

});
