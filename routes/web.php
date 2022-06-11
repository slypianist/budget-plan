<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ExpenseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VendorController;

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



//Route::resource('expense', ExpenseController::class);


Route::resource('users', UserController::class);
Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => ['auth']], function(){
   
    Route::resource('roles', RoleController::class);
    Route::get('expenses', [ExpenseController::class, 'index'])->name('expense.index');
    Route::get('expenses/create', [ExpenseController::class, 'create'])->name('expense.create');
    Route::post('expenses', [ExpenseController::class, 'store'])->name('expense.store');
    Route::get('expenses/{expense}', [ExpenseController::class, 'show'])->name('expense.show');
    Route::get('expenses/{expense}/edit', [ExpenseController::class, 'edit'])->name('expense.edit');
    Route::patch('expenses/{expense}', [ExpenseController::class, 'update'])->name('expense.update');
    Route::delete('expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expense.destroy');
    Route::get('budgets', [BudgetController::class, 'index'])->name('budget.index');
    Route::get('budgets/create', [BudgetController::class, 'create'])->name('budget.create');
    Route::post('budgets', [BudgetController::class, 'store'])->name('budget.store');
    Route::get('budgets/{budget}/edit', [BudgetController::class, 'edit'])->name('budget.edit');
    Route::patch('budget/{budget}', [BudgetController::class, 'update'])->name('budget.update');
    Route::delete('budgets/{budget}', [BudgetController::class, 'destroy'])->name('budget.destroy');
    Route::get('expense/{expense}/budget-clear', [ApprovalController::class,'budgetClearForm'])->name('budget.check');
    Route::patch('expenses/{expense}/budget-clear', [ApprovalController::class,'budgetClear'])->name('budget.clear');
    Route::patch('expense/{expense}/hod-approve', [ApprovalController::class, 'hodApproval'])->name('expense.approvalhod');
    Route::patch('expense/{expense}/approve', [ApprovalController::class, 'cfoApprove'])->name('expense.approvalcfo');
    Route::patch('expense/{expense}/approval', [ApprovalController::class, 'mdApprove'])->name('expense.approvalmd');
    Route::get('expenses/{expense}/sendexp', [ExpenseController::class, 'sendExpense'])->name('expense.send');
    Route::post('expenses/{expense}/md-comment', [ExpenseController::class, 'addMdComment']);
    Route::post('expenses/{expense}/cfo-comment', [ExpenseController::class, 'addCfoComment']);
    Route::post('expenses/{expense}/show', [ExpenseController::class, 'singleExpense']);
    Route::get('vendors/{vendor}', [VendorController::class, 'show'])->name('vendor.show');
    Route::get('expense/pdf-show', [ExpenseController::class, 'showPdf'])->name('show.pdf');


});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
