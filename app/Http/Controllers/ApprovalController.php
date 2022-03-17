<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:hod-approval', ['only' => ['hodApproval']]);
        $this->middleware('permission:budget-clear', ['only'=>['budgetClear']]);
        $this->middleware('permission:md-approval', ['only'=>['mdApproval']]);
        $this->middleware('permission:cfo-approval', ['only' => ['cfoApproval']]);
    }

    public function hodApproval($id){
        $expense = Expense::where('id', $id)->get();
        $user = $expense->user->email;
        $expense->hod_approval = 1;
        // Send Email notification to initiator and Budget Officer
        return back()->with('message', 'Expense has been approved for budget clearing');

    }

    public function budgetClearForm($id){
        $expense = Expense::findOrFail($id);
        $budgets =  Budget::get(['id', 'head']);
        return view('budget.budget-clear', compact('expense','budgets'));
    }

    public function budgetClear(Request $request, $id){
        $expense =Expense::findOrFail($id);
     //   dd($request->all());
        $expense['budget_id'] = $request->budget;
        $b_id = $expense['budget_id'];
        $e_total = $expense->total;

        $budget = Budget::where('id', $b_id)->first();
        if ($budget->prior_exp <= 0.00) {
            $budget->balance -=$e_total;
            $utilization = $e_total + $budget->total_prior;
            $budget->p_utilization = ($utilization/$budget->amount)*100;
            $budget->prior_exp = $e_total;
            $expense['budget_exp_bal'] = $budget->balance;
            $budget->save();
            $expense->budget_cleared = 1;
            $expense->exp_index = 1;
            $expense->save();

        }elseif ($budget->prior_exp >= 1.00) {
            $budget->balance -=$e_total;
            $budget->total_prior += $budget->prior_exp;
            $utilization = $e_total + $budget->total_prior;
            $budget->p_utilization = ($utilization/$budget->amount)*100;
            $budget->prior_exp = $e_total;
            $expense['budget_exp_bal'] = $budget->balance;
            $budget->save();
            $expense->budget_cleared = 1;
            $expense->save();

        }

        return redirect()->route('expense.index')->with('message', 'Your expense budget has been cleared successfully');
    }

    public function cfoApprove($id){
        $expense =Expense::where('id', $id)->first();
       // dd($expense);
        $expense->cfo_approval = 1;
        $expense->save();
        // Send email notification to MD
        return redirect()->route('expense.index')->with('message','You have recommended this expense for approval');
    }

    public function mdApprove($id){
        $expense =Expense::where('id', $id)->first();
       // dd($expense);
        $expense->md_approval = 1;
        $expense->status = 'APPROVED';
        $expense->save();
        // Send email notification to MD
        return redirect()->route('expense.index')->with('message','You have approved this expense for execution');
    }
}
