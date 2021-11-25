<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Expense;
use App\Models\Expense_item;
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
        $expenses = Expense::orderBy('id', 'DESC')->paginate(5);
        return view('expense.index', compact($expenses, 'expenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $budgets = Budget::pluck('head', 'id')->all();
     //dd($budgets);
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
            'budget' => 'nullable', 'string',
            'multi.*.qty' => 'required',
            'multi.*.amount' => 'required',
            'multi.*.item' => 'required',
            'name' => 'required',
            'account' => 'required|numeric',
            'bank' => 'required|string',
            'invoice' => 'required|file'
        ]);
        $expense = new Expense();
        $expense['description'] = $request->description;
        $expense['comment'] = $request->comment;
        $expense['user_id'] = Auth::user()->id;
       // $expense['hod'] = $request->hod;
        //$expense['budget'] = $request->budget;
        $expense->save();
        foreach ($request->multi as $key => $value) {
            $expense->expense_items()->create($value);
        }



            if ($request->hasFile('invoice')){

                $fileNameExtension = $request->file('invoice')->getClientOriginalName();
                $fileExtension = $request->file('invoice')->getClientOriginalExtension();
                $fileName = pathinfo($fileNameExtension, PATHINFO_FILENAME);
                $fileNameToStore = $fileName.'_'.time().$fileExtension;
                $path = $request->file('invoice')->storeAs('public/uploads', $fileNameToStore);
        }

            $data['name'] = $request->name;
            $data['account'] = $request->account;
            $data['bank'] = $request->bank;
            $data['invoice'] = $fileNameToStore;
            $expense->vendors()->create($data);


        return redirect()->route('expense.create')->with('message','Expense overhead has been added successfully');
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
        return view('expense.show', compact('expense', 'items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
}
