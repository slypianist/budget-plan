<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Vendor;
use App\Models\Expense;
use App\Models\Expense_item;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Expense $expenses)
    {
        $expenses = Expense::with('budget')->get();//orderBy('id', 'DESC')->paginate(5);
        return view('expense.index', compact($expenses, 'expenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $budgets = Budget::get(['id', 'head']);
    // dd($budgets);
        return view('expense.create', compact('budgets'));
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
            'hod' => 'nullable', 'string',
          //
            'budget' => 'nullable', 'string',
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
       // $expense['hod'] = $request->hod;
       // $expense['budget_id'] = $request->budget;
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
            if ($expense->exp_index == 1) {
                $budget->total_prior = 0.00;
                $data['priorUtil'] = $budget->total_prior;
            } else {
                $data['priorUtil'] = $budget->total_prior;
            }
            $data['totalBudget'] = $budget->total_prior + $expense->total;
            $data['curExpense'] = $expense->total;
            $data['availBud'] = $expense->budget_exp_bal;
            $data['totalExp'] = $budget->total_prior + $expense->total;
            $data['percentUtil'] = ($data['totalExp']/$budget->amount)*100;
        }


        return view('expense.show', compact('expense', 'items', 'vendor', 'budget', 'data'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function sendExpense(){

    }
}
