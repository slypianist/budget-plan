<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\User;
use App\Models\Budget;
use App\Models\Vendor;

use App\Models\Expense;
use App\Models\Expense_item;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use App\Notifications\NewExpense;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use NumberFormatter;

class ExpenseController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:expense-list|expense-edit|expense-delete', ['only' => ['index']]);
        $this->middleware('permission:expense-create', ['only'=>['create', 'store']]);
        $this->middleware('permission:expense-edit', ['only'=>['edit', 'update']]);
        $this->middleware('permission:expense-delete', ['only' => ['destroy']]);
    }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Expense $expenses, Request $request)
    {
        $expenses = Expense::with('budget')->orderBy('id', 'DESC')->paginate(10);
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
           
        ]);
       // dd($request->all());
       /* if($request->type =="Petty Cash"){

       }
       else{} */
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
               // $path = $request->file('invoice')->storeAs('public/uploads/invoices', $fileNameToStore);
               $path = $request->file('invoice')->move(public_path('uploads/invoices'), $fileNameToStore);
        }

            $data['name'] = $request->name;
            $data['account'] = $request->account;
            $data['bank'] = $request->bank;
            $data['invoice'] = $fileNameToStore;
            $expense->vendors()->create($data);


        return redirect()->route('home')->with('message','Your expense has been added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense){

        $items = Expense_item::where('expense_id', $expense->id)->get();
        $vendor = Vendor::where('expense_id', $expense->id)->first();
        $budget = Budget::where('id', $expense->budget_id)->first();
        $cfo = User::where('designation', 'CFO')->first();
        $md = User::where('designation', 'MD')->first();
        $hod = User::where('id', $expense->apv_hod)->first();
        $bo = User::role('Budget-officer')->first();
        $f = new NumberFormatter('in', NumberFormatter::SPELLOUT);
       // dd($bo);
        //dd($hod->lname);
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


        return view('expense.show', compact('expense', 'items', 'vendor', 'budget', 'data', 'cfo', 'md', 'hod','bo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        if($expense->hod_approval == 1) {
            return back()->with('error', 'This operation is not allowed. Expense has been sent for approval');

        }else{
             //  $expense = Expense::findOrFail($id);
      $id = $expense->id;
      $ex_items = Expense_item::where('expense_id', $id)->get();
      $vendors = Vendor::where('expense_id', $id)->first();
      //dd($vendors);
      $budgets = Budget::all();
      return view('expense.edit', compact('expense', 'ex_items', 'vendors', 'budgets'));

        }
     
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

    // Send Expense for  Approval to HOD
    public function sendExpense(Expense $expense){

        // Check if expense has been sent.
        if($expense->hod_approval == 1){
            return back()->with('error', 'Not allowed!. This expense has already been sent for approval.');

        }else{

            $id = $expense->apv_hod;
            $recipient = User::where('id', $id)->first();
             $recipient->notify(new NewExpense($expense));
          // Notification::send($recipient, new NewExpense($expense));
           return redirect()->route('home')->with('message', 'Your expense has been sent for approval');

        }
    }

    public function addHodComment(Expense $expense, Request $request){
        $expense->hod_comment = $request->comment;
        $expense->save();
        return response()->json(['message'=> 'Your comment has been added', 'status'=>200]);

    }

    // Add budget Officer

    public function addBoComment(Expense $expense, Request $request){
        $expense->bo_comment = $request->comment;
        $expense->save();
        // Send notification
        return response()->json(['status'=>'Successful']);

    }

    // Add CFO Comment

    public function addCfoComment(Expense $expense, Request $request){
        $expense->cfo_comment = $request->comment;
        if($expense->budget_cleared ===0){
            return response()->json(['message'=>'This has not been budget cleared']);
        }
        $expense->save();
        // Send the notification
        return response()->json(['message'=> "Your comment has been added", 'status'=>200]);

    }

    // Show MD Comment.

    public function addMdComment(Expense $expense, Request $request){

        $expense->md_comment = $request->comment;

        $expense->status = "DECLINED";

        $expense->save();

        // Send notification

        return response()->json(['status'=> 200, 'message'=>"Your comment has been added"]);

    }

    // Return single Expense in JSON

    public function singleExpense(Expense $expense){
        return response()->json($expense);
    }

    // Export to PDF

    public function showPdf(Expense $expense){

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

       $pdf = PDF::loadView('expense.expdf', compact('expense', 'items', 'vendor', 'budget', 'data', 'cfo', 'md'));
       
       return $pdf->download('expense.pdf');

    }

    public function updatePaymentStatus(Expense $expense){
        if($expense->md_approval === 1){
            $expense->payment_status = "PAID";
        $expense->update();
        return response()->json(['status'=>200, 'message'=>'successful', 'payment_status'=>$expense->payment_status]);

        }else{
        return response()->json(['status'=>404, 'message'=>'Not allowed. Expense has not been approved']);
        }
        

    }
}
