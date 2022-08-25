<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Petty_expense;
use Illuminate\Support\Facades\Validator;

class PettyExpenseController extends Controller
{
    public function index(){
        return view('petty-expense.index');
    }

    public function create(){
        $users = User::where('designation', 'hod')->get();
       return view('petty-expense.create', compact('users'));
    }

    public function store(Request $request){

        //validation
        $validator = Validator::make($request->all, [



        ], $messages = [
            
        ]);

        //Check for upload

        // Save PettyCash Expense.

    }

    public function edit(Request $request, Petty_expense $petty){



    }

    public function delete(Petty_expense $petty){

    }
}
