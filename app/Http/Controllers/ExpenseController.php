<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Budget;
use App\Models\Vendor;
use App\Models\Expense;
use App\Models\Expense_item;
use App\Notifications\NewExpense;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Expense $expenses, Request $request)
    {
        $expenses = Expense::with('budget')->orderBy('id', 'DESC')->paginate(4);
        return view('expense.index', compact($expenses, 'expenses'))->with('i', ($request->input('page', 1)- 1) *5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $budgets = Budget::get(['id', 'head']);
        $users = User::where('designation', 'HOD')->get(['id', 'fname', 'lname']);
       // dd($users);
    // dd($budgets);
        return view('expense.create', compact('budgets', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required', 'string,',
            'comment' => 'nullable', 'string|',
            'apv_hod' => 'required', 'integer',
            'multi.*.qty' => 'required',
            'multi.*.amount' => 'required',
            'multi.*.item' => 'required',
            'name' => 'required',
            'account' => 'required|numeric',
            'bank' => 'required|string',
            'invoice' => 'required|file'
        ]);
       // dd($request->all());
        $expense = new Expense();
        $expense['description'] = $request->description;
        $expense['comment'] = $request->comment;
        $expense['total'] = $request->total;
        $expense['user_id'] = Auth::user()->id;
        $expense['apv_hod'] = $request->apv_hod;
        $expense->save();
        foreach ($request->multi as $key => $value) {
            $expense->expense_items()->create($value);
        }



            if ($request->hasFile('invoice')){

                $fileNameExtension = $request->file('invoice')->getClientOriginalName();
                $fileExtension = $request->file('invoice')->getClientOriginalExtension();
                $fileName = pathinfo($fileNameExtension, PATHINFO_FILENAME);
                $fileNameToStore = $fileName.'_'.time().'.'.$fileExtension;
                $path = $request->file('invoice')->storeAs('public/uploads/invoices', $fileNameToStore);
        }

            $data['name'] = $request->name;
            $data['account'] = $request->account;
            $data['bank'] = $request->bank;
            $data['invoice'] = $fileNameToStore;
            $expense->vendors()->create($data);


        return redirect()->route('expense.index')->with('message','Your expense has been added successfully and sent for approval');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        $items = Expense_item::where('expense_id', $expense->id)->get();
        $vendor = Vendor::where('expense_id', $expense->id)->first();
        $budget = Budget::where('id', $expense->budget_id)->first();
        $cfo = User::where('designation', 'CFO')->first();
        $md = User::where('designation', 'MD')->first();
       // Show Expense details without budget clearing.
        if(!$budget){
            if ($expense->exp_index == 1) {
                $budget->total_prior = 0.00;
                $data['priorUtil'] = 0.00;
            } else {
                $data['priorUtil'] = 0.00;
            }
            $data['totalBudget'] = 0.00;
            $data['curExpense'] = $expense->total;
            $data['availBud'] = $expense->budget_exp_bal;
            $data['totalExp'] = 0.00;
            $data['percentUtil'] = ($data['totalExp']/1)*100;
        }else {
            // Show expense details that is budget cleared but the first expense on the budget head.
            if ($expense->exp_index == 1) {
                $budget->total_prior = 0.00;

                $data['priorUtil'] = $budget->total_prior;
            } else {

                //Show subsequent expenses that is budget cleared with details.

                $data['priorUtil'] = $budget->amount-$expense->budget_exp_bal-$expense->total;
            }
            $data['totalBudget'] = $budget->total_prior + $expense->total;
            $data['curExpense'] = $expense->total;
            $data['availBud'] = $expense->budget_exp_bal;
            $data['totalExp'] = $data['priorUtil'] + $expense->total;
            $data['percentUtil'] = ($data['totalExp']/$budget->amount)*100;
        }


        return view('expense.show', compact('expense', 'items', 'vendor', 'budget', 'data', 'cfo', 'md',));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        $ex_items = Expense_item::where('expense_id', $id)->get();
        $vendors = Vendor::where('expense_id', $id)->first();
        //dd($vendors);
        $budgets = Budget::all();
        return view('expense.edit', compact('expense', 'ex_items', 'vendors', 'budgets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return "This action is yet to be activated by the admin...";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return "This action is yet to be activated by the Admin...";
    }

    public function sendExpense(Expense $expense){

        $id = $expense->apv_hod;

       $recipient = User::where('id', $id)->first();
       //dd($recipient);
        $recipient->notify(new NewExpense($expense));
     // Notification::send($recipient, new NewExpense($expense));

      return redirect()->route('home')->with('message', 'Your expense has been sent for approval');

    }

    public function addHodComment(Expense $expense, Request $request){
        $expense->hod_comment = $request->comment;
        $expense->save();
        return response()->json(['message'=> 'Your comment has been added', 'status'=>200]);

    }

    public function addBoComment(Expense $expense, Request $request){
        $expense->bo_comment = $request->comment;
        $expense->save();
        // Send notification
        return response()->json(['status'=>'Successful']);

    }

    public function addCfoComment(Expense $expense, Request $request){
        $expense->cfo_comment = $request->comment;
        $expense->save();
        // Send the notification

        return response()->json(['message'=> "Your comment has been added", 'status'=>200]);

    }

    public function addMdComment(Expense $expense, Request $request){

        $expense->md_comment = $request->comment;
        $expense->status = "DECLINED";

        $expense->save();

        // Send notification

        return response()->json(['status'=> 200, 'message'=>"Your comment has been added"]);

    }

    public function singleExpense(Expense $expense){
        return response()->json($expense);

    }
}
