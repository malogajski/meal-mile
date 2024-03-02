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
    // Category
    Route::get('categories', \App\Livewire\Category\Index::class)->name('categories');

    // Sub-Category
    Route::get('sub-categories', \App\Livewire\Subcategory\Index::class)->name('sub-categories');

//    Route::get('item/create', [\App\Http\Controllers\ItemController::class, 'create'])->name('item.create');
//    Route::get('item/{id}/edit', [\App\Http\Controllers\ItemController::class, 'edit'])->name('item.edit');
//    Route::post('item/store', [\App\Http\Controllers\ItemController::class, 'store'])->name('item.store');

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
