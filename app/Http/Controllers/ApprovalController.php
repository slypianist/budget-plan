<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Budget;
use App\Models\Expense;
use App\Notifications\ApprovedExpense;
use App\Notifications\CfoExpenseApproval;
use App\Notifications\MdExpenseApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ApprovalController extends Controller
{
    /**
     * Set Permissions.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:hod-approval', ['only' => ['hodApproval']]);
        $this->middleware('permission:budget-clear', ['only'=>['budgetClear']]);
        $this->middleware('permission:md-approval', ['only'=>['mdApproval']]);
        $this->middleware('permission:cfo-approval', ['only' => ['cfoApproval']]);
    }

    /**
     * Expense Approval by Head of Department.
     *
     * @return Flash messages
     */

    public function hodApproval($id){
//dd("Expense approved for clearing");
        $expense = Expense::where('id', $id)->get();
        $user = $expense->user->email;
        $expense->hod_approval = 1;
        // Send Email notification to initiator and Budget Officer
        return back()->with('message', 'Expense has been approved for budget clearing');

    }

    /**
     * Display Budget Clearing Form.
     *
     * @return \Illuminate\Http\Response
     */
    public function budgetClearForm($id){
        $expense = Expense::findOrFail($id);
        $budgets =  Budget::get(['id', 'head']);
        return view('budget.budget-clear', compact('expense','budgets'));
    }

    /**
     * Expense Budget Clearing Module.
     *
     * @return \Illuminate\Http\Response
     */

    public function budgetClear(Request $request, $id){
        $expense =Expense::findOrFail($id);
        if($expense->hod_approval === 1){

                 //   dd($request->all());
     // Check if expense has been cleared.
     if($expense->budget_cleared == 0){

        $expense['budget_id'] = $request->budget;
        $b_id = $expense['budget_id'];
        $e_total = $expense->total;

        $budget = Budget::where('id', $b_id)->first();
        $user = User::Permission('cfo-approval')->first();
        // Check if there is prior expense
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
        // Send notification
        $user->notify(new CfoExpenseApproval($expense));
        return redirect()->route('expense.index')->with('message', 'Your expense budget has been cleared successfully');

     }else{
         return redirect()->route('expense.index')->with('message', "Oops! Failed. This expense has already been budget cleared.");
     }

        }else{
            return redirect()->route('expense.index')->with('message', "Action Failed! This expense has not been approved for budget clearing.");
        }


    }

    /**
     * Expense Approval recommendation by CFO.
     *
     * @return \Illuminate\Http\Response
     */
    public function cfoApprove($id){
        $expense =Expense::where('id', $id)->first();
        if($expense->budget_cleared == 0){

            return redirect()->route('expense.index')->with('message', 'Sorry Substantive CFO! This action cannot be completed. This expense has not been Budget Cleared.');

        }else{

            $user = User::Permission('md-approval')->first();
        $expense->cfo_approval = 1;
        $expense->save();
        // Send email notification to MD
        $user->notify(new MdExpenseApproval($expense));

        return redirect()->route('expense.index')->with('message','You have successfully recommended this expense for approval');
        }

    }

    /**
     * Expense Approval recommendation by MD.
     *
     * @return \Illuminate\Http\Response
     */
    public function mdApprove($id){
        $expense =Expense::where('id', $id)->first();
        // Get the user instance of initiator.
       // $user = User::where('id', $expense->user_id)->first();
       if($expense->cfo_approval == 0){

        return redirect()->route('expense.index')->with('message', 'Sorry! This action cannot be completed. This expense has not been recommended for Approval by the CFO.');

       }
       else{

        $user = User::Role('payment-initiator')->first();
        $expense->md_approval = 1;
        $expense->status = 'APPROVED';
        $expense->save();
        // Send email notification
        $user->notify(new ApprovedExpense($expense));
        return redirect()->route('expense.index')->with('message','You have approved this expense for execution');

       }

    }
}
