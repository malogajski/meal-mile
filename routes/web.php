<?php

use Illuminate\Support\Facades\Route;

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

Route::view('/', 'welcome');

Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::group(['middleware' => ['auth', 'verified']], function () {
    // Items
    Route::get('items', App\Livewire\Item\Index::class)
        ->name('items');

    // Shopping
    Route::get('shopping-list', App\Livewire\ShoppingList\Index::class)
        ->name('shopping-list');
    Route::get('shopping-list/create', App\Livewire\ShoppingList\Create::class)
        ->name('shopping-list-create');
    Route::get('shopping-list/{id}/edit', App\Livewire\ShoppingList\Create::class)
        ->name('shopping-list-edit');
    Route::get('shopping-list/{id}/items', App\Livewire\ShoppingListItem\Create::class)
        ->name('shopping-list-items');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
