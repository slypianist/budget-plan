<?php

use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ExpenseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('expense', ExpenseController::class);
Route::get('expenses', [ExpenseController::class, 'index'])->name('expense.index');
Route::get('expenses/create', [ExpenseController::class, 'create'])->name('expense.create');
Route::post('expenses', [ExpenseController::class, 'store'])->name('expense.store');
Route::get('expenses/show/{expense}', [ExpenseController::class, 'show']);
Route::get('budgets', [BudgetController::class, 'index'])->name('budget.index');
Route::get('budgets/create', [BudgetController::class, 'create'])->name('budget.create');
Route::post('budgets', [BudgetController::class, 'store'])->name('budget.store');
Route::get('budgets/{budget}/edit', [BudgetController::class, 'edit'])->name('budget.edit');
Route::patch('budget/{budget}', [BudgetController::class, 'update'])->name('budget.update');
Route::delete('budgets/{budget}', [BudgetController::class, 'destroy'])->name('budget.destroy');

Route::resource('users', UserController::class);

Route::group(['middleware' => ['auth']], function(){
   Route::resource('roles', RoleController::class);

   Route::resource('products', ProductController::class);


});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
